<?php
class ProfilesController extends AppController {
	
	var $name = 'Profiles';

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
				$this->redirect(array('action' => 'edit'));
			}
		}
    } 
}