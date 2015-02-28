<?php 

App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel{
	
	private var $roles = array(
		'User',
		'Admin'
	);
	
	public var $hasOne = array(
		'Profile' => array(
			'classname' => 'Profile',
			'dependent' => true
		/* This is commneted out until we deal with money matters.		
		),
		'Wallet' => array(
			'classname' => 'Wallet'
			'dependent' => true
		*/
		)
	);

	public var $validate = array(
		'username' => array(
			'alphaNumeric' =>array(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Your username may only be alpha-numeric characters.'
			),
			'between' => array(
				'rule' => array('lengthBetween', 1, 25),
				'message' => 'Username must be between 1 to 25 characters.'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'required' => true,
				'allowEmpty' => false,
				'on' => 'create',
				'last' => false,
				'message' => 'That username aslready exists! Please choose another username.'
			)
		),
		'password' => array(
			'between' => array(
				'rule' => array('lengthBetween', 5, 16),
				'message' => 'Your password must be between 5 and 16 characters long.'
			),
			'matchPassword' => array(
				'rule' => 'matchPasswords',
				'message' => 'Your passwords do not match!'
			)
		),
		'password_confirmation' => array(
			'between' => array(
				'rule' => array('lengthBetween', 5, 16),
				'message' => 'Your password must be between 5 and 16 characters long.'	
			)
		),
		'email' => array(
			'between' => array(
				'rule' => array('lengthBetween', 1, 50),
				 'message' => 'E-mail must be between 1 to 50 characters.'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'required' => true,
				'allowEmpty' => false,
				'on' => 'create',
				'last' => false,
				'message' => 'E-mail already exists!'
			),
			'email' => 'email'
		)
	);	

	/* Checks if the password and password2 field contain the same password.
	 - Used for the match passwords validation check. 
	*/
	public function matchPassword($data){
		if(isset($this->data[$this->alias]['password2'])){
			return $this->data[$this->alias]['password2'] === current($data);
		}
		return true;
	}

	/* Before save function used by Cakephp. 
	- Method sugguested by the CakePhP CookBook. 
	*/
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
			);
		}
		return true;
	}



}
?>
