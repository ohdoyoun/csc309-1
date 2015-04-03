<?php
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
class ProfilesController extends AppController {
	
	public $name = 'Profiles';
	
	#Change hasher to blowfish to be able to change passwords
    public $components = array(
        'Session',
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish'
                )
            )
        )
    );
	
	public function beforeFilter() {
        parent::beforeFilter(); 
        if (!($this->Auth->user())) {
            $this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
        }
        
    }

    public function isAuthorized($user) {
         if (in_array($this->action, array('user'))) {
            if ($user['id'] != $this->request->params['pass'][0]) {      
                return false;   
            }
         }
         return true;
    } 

	function index() {
		$this->set('profiles', $this->Profile->find('all'));
	}
    
    function view($id = NULL) {
        $this->set('profile', $this->Profile->find('first', array('conditions' => array('Profile.id' => $id))));    
    }
    
    function settings() {
        if (isset($this->data['Profile']['deleteAccount'])) {
            $id = $this->Auth->user('id');
            $this->Profile->User->delete(array('User.id' => $id), true);
            $this->redirect($this->Auth->logout());
        } elseif (isset($this->data['Profile']['passwordChange'])) {
            //Get password from database
            $currentPassword = $this->Profile->query('SELECT password FROM users WHERE id=' . $this->Auth->user('id') . ';')[0]['users']['password'];
            $passwordHasher = new BlowfishPasswordHasher();
            $data['Profile']['old_password'] = Security::hash($this->data['Profile']['old_password'], 'blowfish', $currentPassword);
            
            debug($data['Profile']['old_password']);
            debug($currentPassword);
            #debug()
            
            if ($currentPassword == $data['Profile']['old_password']) {
                if ($this->data['Profile']['new_password'] == $this->data['Profile']['confirm_password'] and strlen($this->data['Profile']['new_password']) >= 5) {
                    $data['Profile']['new_password'] = $passwordHasher->hash($this->data['Profile']['new_password']);
                    $this->Profile->query('UPDATE users SET password=\'' . $data['Profile']['new_password'] . '\' WHERE id=' . $this->Auth->user('id') . ';');
                } else {
                    $this->Session->setFlash('New password mismatch or it is less than 5 characters long.');
                    debug('1');
                }
            } else {
                $this->Session->setFlash('Your old password doesn\'t match your current password.');
                debug('2');
            }
        } elseif (isset($this->data['Profile']['timezoneChange'])) {
            
        } elseif (isset($this->data['Profile']['signOut'])) {
            $this->Session->destroy();
            $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
        }
    }
    
    function notifications() {
        
    }
    
    function search() {
        if (!empty($this->data)) {
            if ($this->Profile->User->find('first', array('conditions' => array('User.username' => $this->data['Profile']['username'])))) {
                $this->set('userSearch', $this->Profile->User->find('first', array('conditions' => array('User.username' => $this->data['Profile']['username'])))['Profile']['id']);
            }
        }
    }
    
    function edit() {
        
        $this->set('email', $this->Auth->user('email'));
        
        $conditions = array("Profile.user_id" => $this->Auth->user('id'));
        $id = NULL;
        $prof_id = NULL;
        $userprofile = NULL;
        if (!empty($userprofile = $this->Profile->find('first', array('conditions' => $conditions)))) {
            $this->Session->setFlash("Your Profile");
            $this->set('users', $userprofile['Profile']);
            $prof_id = $userprofile['Profile']['id'];#$up['id'];

            
        } else {
            $this->Session->setFlash("Profile Setup");
            $this->set('users', $userprofile);
        }
        
        if (!empty($this->data)) {         
            $this->request->data['Profile']['user_id'] = $this->Auth->user('id');
            $this->request->data['Profile']['id'] = $prof_id;            
            $this->request->data['Profile']['dob'] = $this->request->data['Profile']['dob']['year'] . "-" . $this->request->data['Profile']['dob']['month'] . "-" . $this->request->data['Profile']['dob']['day'];
            
            $dataSave = array();
            $dataSave['Profile']['id'] = $this->request->data['Profile']['id'];
            $dataSave['Profile']['first_name'] = $this->request->data['Profile']['first_name'];
            $dataSave['Profile']['last_name'] = $this->request->data['Profile']['last_name'];
            $dataSave['Profile']['user_id'] = $this->request->data['Profile']['user_id'];
            $dataSave['Profile']['country'] = $this->request->data['Profile']['country'];
            $dataSave['Profile']['province'] = $this->request->data['Profile']['province'];
            $dataSave['Profile']['city'] = $this->request->data['Profile']['city'];
            $dataSave['Profile']['address'] = $this->request->data['Profile']['address'];
            $dataSave['Profile']['postal_code'] = $this->request->data['Profile']['postal_code'];
            $dataSave['Profile']['phone_number'] = $this->request->data['Profile']['phone_number'];
            $dataSave['Profile']['dob'] = $this->request->data['Profile']['dob'];
            $dataSave['Profile']['gender'] = $this->request->data['Profile']['gender'];
            $dataSave['Profile']['bio'] = $this->request->data['Profile']['bio'];
            
            $dataUser = array();
            $dataUser['User']['id'] = $this->Auth->user('id');
            $dataUser['User']['email'] = $this->request->data['Profile']['email'];
            
			if ($this->Profile->save($dataSave, false) and $this->Profile->User->save($dataUser, false)) {
                
                #Update users email in session
                $this->Session->write('Auth.User.email', $dataUser['User']['email']);
				$this->Session->setFlash('Changes successful.');
				#$this->redirect(array('action' => 'edit'));
			}
		}
    } 
}
