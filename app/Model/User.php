<?php 
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel{
	
	// The name of this Model.
	public $name = 'User';
	
	// The table that this Model uses.
	public $useTable = 'users';
	
	/* Roles array used to store possible values of the role field.	*/
	private $roles = array(
		'User',
		'Admin'
	);
	
	/* The associations of this Model with other Models based on the database. */
	public $hasOne = array(
		'Profile' => array(
			'className' => 'Profile',
			'dependent' => true
		/* This is commneted out until we deal with money matters.		
		),
		'Wallet' => array(
			'classname' => 'Wallet'
			'dependent' => true
		*/
		)
	);
	
	public $hasMany = array(
		'Post' => array(
			'className' => 'User',
			'dependent' => true
		)
	);
	
	/* Associations with the Project Model. */
	public $hasAndBelongsToMany = array(
		'Project' => array(
			'className' => 'Project',
			'joinTable' => 'initiators',
			'with' => 'Initiator',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'project_id'
		)
	);

	/* The validation rules that this model must follow. 
	- Mostly dervived from the database.
	*/
	public $validate = array(
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
    public function matchPasswords($data) {
        if ($data['password'] == $this->data['User']['password_confirmation']) {
            return true;
        }
        $this->invalidate('password_confirmation', 'Your passwords do not match.');
        return false;
    }
	
	/* Checks if the chosen role is one of the given choices.
	- Used for validation.
	*/
	public function oneOf($data){
		if(isset($this->data[$this->alias]['role'])){
			foreach($roles as $i){
				if($this->data[$this->alias]['role'] == $i){
					return true;
				}
			}
			return false;
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
