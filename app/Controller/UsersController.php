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
           }
       }
	}
    
    public function logout() {
        $this->redirect($this->Auth->logout());
    }

	function index() {
		$this->set('users', $this->User->find('all'));
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
				$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
			} else {
				$this->Session->setFlash('Please correct the fields highlighted in red to register.');
			}
		}
	}     
}