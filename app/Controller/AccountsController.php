<?php
class AccountsController extends AppController {
    function index() {
		
	}
    
    function profile() {
        
        $id = NULL;      
        $userprofile = NULL;
        $email = $this->Account->query("SELECT email FROM users WHERE " . $this->Auth->user('id') . "=users.id LIMIT 1;")[0]['users']['email'];
        $this->set('email', $email);
        
        if (!empty($userprofile = $this->Account->query("SELECT * FROM profiles WHERE " . $this->Auth->user('id') . "= profiles.user_id LIMIT 1;"))) {
            #$this->Session->setFlash("Your Profile");
            $this->set('users', $userprofile);
            foreach ($userprofile as $up)
                $id = $up['profiles']['id'];
              /*  $this->set('id', $up['profiles']['id']);*/
        } else {
            $this->Session->setFlash("Profile Setup");
            $this->set('users', $userprofile);
        }

        if (!empty($this->data)) {
            $user_id = $this->Auth->user('id');
            /*$this->Account->set(['profiles']['user_id'], $this->Auth->user('id'));*/

            if ($id) {
                $this->Account->query("UPDATE profiles SET id=" . $id . ", user_id=" . $user_id . ", first_name='" . $this->request->data['Account']['first_name'] . "', last_name='" . $this->request->data['Account']['last_name'] . "', dob='" . $this->request->data['Account']['date_of_birth']['month'] . "-" . $this->request->data['Account']['date_of_birth']['day'] . "-" . $this->request->data['Account']['date_of_birth']['year'] . "', gender='" . $this->request->data['Account']['gender'] . "', country='" . $this->request->data['Account']['country'] . "', province='" . $this->request->data['Account']['province'] . "', city='" . $this->request->data['Account']['city'] . "', address='" . $this->request->data['Account']['address'] . "', postal_code='" . $this->request->data['Account']['postal_code'] . "', phone_number='" . $this->request->data['Account']['phone_number'] . "', bio='" . $this->request->data['Account']['biography'] . "' WHERE profiles.user_id=" . $user_id . ";"); 
                
                if ($this->Account->query("SELECT COUNT(*) AS total FROM users WHERE email='" . $this->request->data['Account']['email'] . "' and id!='" . $user_id . "';")[0][0]['total'] == 0) {
                    $this->Account->query("UPDATE users SET email='" . $this->request->data['Account']['email'] . "' WHERE users.id=" . $user_id . ";");
                    $this->Session->setFlash('Profile saved.');
                    $this->redirect(array('action' => 'index')); 
                } else {
                   $this->Session->setFlash('E-mail already in use.');
                   $this->redirect(array('action' => 'profile'));  
                }
                 

            } else {
                $this->Account->query("INSERT INTO profiles (user_id, first_name, last_name, dob, gender, country, province, city, address, postal_code, phone_number, bio) VALUES ('" . $user_id . "','" . $this->request->data['Account']['first_name'] . "','" . $this->request->data['Account']['last_name'] . "','" . $this->request->data['Account']['date_of_birth']['month'] . "-" . $this->request->data['Account']['date_of_birth']['day'] . "-" . $this->request->data['Account']['date_of_birth']['year'] . "','" . $this->request->data['Account']['gender'] . "','" . $this->request->data['Account']['country'] . "','" . $this->request->data['Account']['province'] . "','" . $this->request->data['Account']['city'] . "','" . $this->request->data['Account']['address'] . "','" . $this->request->data['Account']['postal_code'] . "','" . $this->request->data['Account']['phone_number'] . "','" . $this->request->data['Account']['biography'] . "');" );
                
                if ($this->Account->query("SELECT COUNT(*) AS total FROM users WHERE email='" . $this->request->data['Account']['email'] . "' and id!='" . $user_id . "';")[0][0]['total'] == 0) {
                    $this->Account->query("UPDATE users SET email='" . $this->request->data['Account']['email'] . "' WHERE users.id=" . $user_id . ";");
                    $this->Session->setFlash('Profile saved.');
                    $this->redirect(array('action' => 'index')); 
                } else {
                   $this->Session->setFlash('E-mail already in use.');
                   $this->redirect(array('action' => 'profile'));  
                }

            }

            /*if ($this->Account->save($this->data)) {
                $this->Session->setFlash('Changes successful.');
                $this->redirect(array('action' => 'profile/edit'));
            }*/
        }
        
    }
}