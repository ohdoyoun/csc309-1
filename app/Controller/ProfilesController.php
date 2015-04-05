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
            
            if ($currentPassword == $data['Profile']['old_password']) {
                if ($this->data['Profile']['new_password'] == $this->data['Profile']['confirm_password'] and strlen($this->data['Profile']['new_password']) >= 5) {
                    $data['Profile']['new_password'] = $passwordHasher->hash($this->data['Profile']['new_password']);
                    $this->Profile->query('UPDATE users SET password=\'' . $data['Profile']['new_password'] . '\' WHERE id=' . $this->Auth->user('id') . ';');
                } else {
                    $this->Session->setFlash('New password mismatch or it is less than 5 characters long.');
                }
            } else {
                $this->Session->setFlash('Your old password doesn\'t match your current password.');
            }
        } elseif (isset($this->data['Profile']['timezoneChange'])) {
            
        } elseif (isset($this->data['Profile']['signOut'])) {
            $this->Session->destroy();
            $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
        }
    }
    
    function notifications() {
        $hasPreferences = $this->Profile->query('SELECT count(*) as total FROM notifications WHERE user_id=' . $this->Auth->user('id') . ';')[0][0]['total'];
        $this->set('hasPreferences', $hasPreferences);
        
        $this->set('checkedValues', $this->Profile->query('SELECT * FROM notifications WHERE user_id=' . $this->Auth->user('id') . ';')[0]['notifications']);
        
        if (!empty($this->data)) {
            if ($hasPreferences) {
                $this->Profile->query('DELETE FROM notifications WHERE user_id=' . $this->Auth->user('id') . ';');
                $this->Profile->query('INSERT INTO notifications (user_id, newCommentsBacked, newUpdatesBacked, newPledgesStarted, newCommentsStarted, newProjects) VALUES (' . $this->Auth->user('id') . ', ' . $this->data['Profile']['newCommentsBacked'] . ', ' . $this->data['Profile']['newProjectUpdates'] . ', ' . $this->data['Profile']['newPledges'] . ', ' . $this->data['Profile']['newCommentsYours'] . ', ' . $this->data['Profile']['newCommunities'] . ');');
            } else {
                $this->Profile->query('INSERT INTO notifications (user_id, newCommentsBacked, newUpdatesBacked, newPledgesStarted, newCommentsStarted, newProjects) VALUES (' . $this->Auth->user('id') . ', ' . $this->data['Profile']['newCommentsBacked'] . ', ' . $this->data['Profile']['newProjectUpdates'] . ', ' . $this->data['Profile']['newPledges'] . ', ' . $this->data['Profile']['newCommentsYours'] . ', ' . $this->data['Profile']['newCommunities'] . ');');
            }
        }
    }
    
    function search() {
        if (!empty($this->data)) {
            if ($this->Profile->User->find('first', array('conditions' => array('User.username' => $this->data['Profile']['username'])))) {
                $this->set('userSearch', $this->Profile->User->find('first', array('conditions' => array('User.username' => $this->data['Profile']['username'])))['Profile']['id']);
            }
        }
    }
    
    function edit() {
        $tags = $this->Profile->query('SELECT * FROM macro_tags;');
        
        $cleanedTags = array();
        
        foreach($tags as $tag):
          $cleanedTags[$tag['macro_tags']['id']] = $tag['macro_tags']['name'];
        endforeach;
        
        $this->set('macroTags', $cleanedTags);
        
        $this->set('email', $this->Auth->user('email'));
        
        $conditions = array("Profile.user_id" => $this->Auth->user('id'));
        $id = NULL;
        $prof_id = NULL;
        $userprofile = NULL;
        if (!empty($userprofile = $this->Profile->find('first', array('conditions' => $conditions)))) {
            $this->set('users', $userprofile['Profile']);
            $prof_id = $userprofile['Profile']['id'];
            $profileId = $this->Profile->query('SELECT id FROM profiles WHERE user_id=' . $this->Auth->user('id') . ';')[0]['profiles']['id'];
            $this->set('macroTag', $this->Profile->query('SELECT macro_tag_id FROM profile_macro_tags WHERE profile_id=' . $profileId . ';'));
            $this->set('microTag', $this->Profile->query('SELECT micro_tags.name FROM profile_micro_tags, micro_tags WHERE profile_micro_tags.micro_tag_id=micro_tags.id and profile_id=' . $profileId . ';'));
            
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
            
            if (strlen($this->data['Profile']['other']) > 0 and strlen($this->data['Profile']['other']) <= 50) {
    			if ($this->Profile->save($dataSave, false) and $this->Profile->User->save($dataUser, false)) {
    			    $profileId = $this->Profile->query('SELECT id FROM profiles WHERE user_id=' . $this->Auth->user('id') . ';')[0]['profiles']['id'];
    			    $this->Profile->query('DELETE FROM profile_macro_tags WHERE profile_id=' . $profileId . ';');
    			    $this->Profile->query('DELETE FROM profile_micro_tags WHERE profile_id=' . $profileId . ';');
    			    
                    $this->Profile->query('INSERT INTO profile_macro_tags (macro_tag_id, profile_id) VALUES (' . $this->data['Profile']['category'] . ', ' . $profileId . ');');
                    if ($this->Profile->query('SELECT count(*) as total FROM micro_tags WHERE name=\'' . $this->data['Profile']['other'] . '\';')[0][0]['total'] == 0) {
                        $this->Profile->query('INSERT INTO micro_tags (name) VALUES (\'' . $this->data['Profile']['other'] . '\');');
                    }
                    $micro_tag_id = $this->Profile->query('SELECT id FROM micro_tags WHERE name=\'' . $this->data['Profile']['other'] . '\' LIMIT 1;')[0]['micro_tags']['id'];
                    $this->Profile->query('INSERT INTO profile_micro_tags (micro_tag_id, profile_id) VALUES (' . $micro_tag_id . ', ' . $profileId . ');');
                        
                    #Update users email in session
                    $this->Session->write('Auth.User.email', $dataUser['User']['email']);
    				$this->Session->setFlash('Changes successful.');
    				$this->redirect(array('controller' => 'profiles', 'action' => 'edit'));
    			}
            } else {
                    $this->Session->setFlash('Other interests must be in between 1 and 50 characters');
                    $this->redirect(array('controller'=>'profiles', 'action'=>'edit'));
            }
		}
    } 
}
