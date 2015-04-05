<?php
class UsersController extends AppController {
	
	public $name = 'Users';
    
    #Change hasher to blowfish to be able to login
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
        $this->Auth->allow('register');
        
    }
    

	public function login() {
       if ($this->Auth->user())
        {
            $this->Session->setFlash('You\'re already logged in.');
            $this->redirect($this->redirect($this->referer()));
        }
        
	   if ($this->request->is('post')) {
           if ($this->Auth->login()) {
               $this->redirect($this->Auth->redirect());
           } else {
               $this->Session->setFlash("Login failed");
               $this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
           }
       }
	}
    
    public function logout() {
        #if (!($this->Auth->user())) {
        #    $this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
        #}

        if($this->Auth->loggedIn()) {
            $this->Session->destroy();
            $this->Auth->logout();
            $this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
        }
    }

    ############DELETE BEFORE RELEASE#################
	function index() {
	   if (!($this->Auth->user())) {
            $this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
        }
	
		$this->set('users', $this->User->find('all'));
	}
	
	function view($id = null) {
	    $this->set('user', $this->User->find('first', array('conditions' => array('User.id' => $id))));
	    
	    $this->set('id', $id);
	    
	    $popularity = array();
        array_push($popularity, $this->User->query('SELECT count(*) as count FROM likes WHERE choice=1 and onUser=' . $id . ';')[0][0]['count']);
        array_push($popularity, $this->User->query('SELECT count(*) as count FROM likes WHERE choice=-1 and onUser=' . $id . ';')[0][0]['count']);
        $this->set('popularity', $popularity);
        
        if (!empty($this->data)) {  
            if (isset($this->data['User']['like'])) {
                if ($this->User->query('SELECT count(*) as count from likes WHERE choice=1 and onUser=' . $this->data['User']['id'] . ' and fromUser=' . $this->Auth->user('id') . ';')[0][0]['count'] > 0) {
                    $this->User->query('DELETE FROM likes WHERE choice=1 and onUser=' . $this->data['User']['id'] . ' and fromUser=' . $this->Auth->user('id') . ';');
                    $this->redirect(array('controller'=>'users', 'action'=>'view/' . $id));
                } else {
                    $this->User->query('DELETE FROM likes WHERE choice=-1 and onUser=' . $this->data['User']['id'] . ' and fromUser=' . $this->Auth->user('id') . ';');
                    $this->User->query('INSERT INTO likes (onUser, fromUser, choice) VALUES (' . $this->data['User']['id'] . ',' . $this->Auth->user('id') . ',1);');
                    $this->redirect(array('controller'=>'users', 'action'=>'view/' . $id));
                }
            } else if (isset($this->data['User']['dislike'])) {
                if ($this->User->query('SELECT count(*) as count from likes WHERE choice=-1 and onUser=' . $this->data['User']['id'] . ' and fromUser=' . $this->Auth->user('id') . ';')[0][0]['count'] > 0) {
                    $this->User->query('DELETE FROM likes WHERE choice=-1 and onUser=' . $this->data['User']['id'] . ' and fromUser=' . $this->Auth->user('id') . ';');
                    $this->redirect(array('controller'=>'users', 'action'=>'view/' . $id));
                } else {
                    $this->User->query('DELETE FROM likes WHERE choice=1 and onUser=' . $this->data['User']['id'] . ' and fromUser=' . $this->Auth->user('id') . ';');
                    $this->User->query('INSERT INTO likes (onUser, fromUser, choice) VALUES (' . $this->data['User']['id'] . ',' . $this->Auth->user('id') . ',-1);');
                    $this->redirect(array('controller'=>'users', 'action'=>'view/' . $id));
                }
            }
        }
	}

	function register() {
        if ($this->Auth->user())
        {
            $this->Session->setFlash('You\'re already registered.');
            $this->redirect($this->redirect($this->referer()));
        }
        
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash('Successfully registered.');
                
                #Automatically login if successfully registered.
                $user = $this->User->findByUsername($this->request->data['username']);
                $this->Auth->login($user);
                $this->User->query('INSERT INTO notifications (user_id) VALUES (' . $this->Auth->user('id') . ');');
				$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
			} else {
				$this->Session->setFlash('Please correct the fields highlighted in red to register.');
			}
		}
	}     
}