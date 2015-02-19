<?php
class ProfilesController extends AppController {
	
	var $name = 'Profiles';

   /* public function isAuthorized($user) {
         if (in_array($this->action, array('user'))) {
            if ($user['id'] != $this->request->params['pass'][0]) {      
                return false;   
            }
         }
         return true;
    } */

	function index() {
		$this->set('profiles', $this->Profile->find('all'));
	}
    
   /* function user($id = NULL) {
        
        $conditions = array("Profile.user_id" => $id);
        $userprofile = NULL;
        if (!empty($userprofile = $this->Profile->find('first', array('conditions' => $conditions)))) {
            $this->Session->setFlash("Your Profile");
            $this->set('users', $userprofile);
            foreach ($userprofile as $up)
                $this->Profile->set('id', $up['id']);
        } else {
            $this->Session->setFlash("Profile Setup");
            $this->set('users', $userprofile);
        }
        
        if (!empty($this->data)) {
            $this->Profile->set('user_id', $this->Auth->user('id'));
			if ($this->Profile->save($this->data)) {
				$this->Session->setFlash('Changes successful.');
				$this->redirect(array('action' => 'user', $id));
			}
		}
    } */
}