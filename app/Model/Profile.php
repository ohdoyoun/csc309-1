<?php 
App::uses('AppModel', 'Model');
class Profile extends AppModel{
	
	public $name = 'Profile';
	
	public $useTable = 'profiles';

	/* The associations of this Model with other Models based on the database. */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
	);

	/* Associations with the Project Model. */
	public $hasAndBelongsToMany = array(
		'MacroTag' => array(
			'className' => 'MacroTag',
			'joinTable' => 'profile_macro_tags',
			'with' => 'ProfilesMacroTag',
			'foreignKey' => 'profile_id',
			'associationForeignKey' => 'macro_tag_id'
		),
		'MicroTag' => array(
			'className' => 'MicroTag',
			'joinTable' => 'profile_micro_tags',
			'with' => 'ProfilesMicroTag',
			'foreignKey' => 'profile_id',
			'associationForeignKey' => 'micro_tag_id'
		)
	);

	/* The validation rules that this model must follow. 
	- Mostly dervived from the database.
	*/
 	public $validate = array(
		'first_name' => array
		(	
			'alphaNumeric' => array
			(
				'rule' => array('custom', '/^[a-z0-9 ]*$/i'),
				'required' => true,
				'message' => 'Your first name may only be alphanumeric characters.',
                'allowEmpty' => true
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 50),
				'message' => 'First name must be between 1 to 50 characters.'
			)
		),
		'last_name' => array
		(
			'alphaNumeric' => array
			(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Your first name may only be alphanumeric characters.',
                'allowEmpty' => true
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 50),
				'message' => 'First name must be between 1 to 50 characters.'
			)
		),
		'email' => array(
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 50),
				'message' => 'E-mail must be between 1 to 50 characters.'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'required' => true,
				'allowEmpty' => false,
				'on' => 'update',
				'last' => false,
				'message' => 'E-mail already exists!'
			),
			'email' => 'email'
		),
		'country' => array
		(
			'alphaNumeric' => array
			(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Country may only be alphanumeric characters.',
                'allowEmpty' => true
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 50),
				'message' => 'Country must be between 1 to 50 characters.'
			)
		),
		'province' => array
		(
			'alphaNumeric' => array
			(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Province may only be alphanumeric characters.',
                'allowEmpty' => true
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 50),
				'message' => 'Province must be between 1 to 50 characters.'
			)
		),
		'city' => array
		(
			'alphaNumeric' => array
			(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'City may only be alphanumeric characters.',
                'allowEmpty' => true
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 100),
				'message' => 'City must be between 1 to 100 characters.'
			)
		),
		'address' => array
		(
			'alphaNumeric' => array
			(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Address may only be alphanumeric characters.',
                'allowEmpty' => true
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 100),
				'message' => 'Address must be between 1 to 100 characters.'
			)
		),
		'postal_code' => array
		(
			'alphaNumeric' => array
			(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Postal code may only be alphanumeric characters.',
                'allowEmpty' => true
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 20),
				'message' => 'Postal code must be between 1 to 20 characters.'
			)
		),
		'phone_number' => array
		(
			'alphaNumeric' => array
			(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Phone number may only be alphanumeric characters.',
                'allowEmpty' => true
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 20),
				'message' => 'Phone number must be between 1 to 20 characters.'
			)
		),
		'biography' => array
		(
			'alphaNumeric' => array
			(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Biography may only be alphanumeric characters.',
                'allowEmpty' => true
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 0, 2000),
				'message' => 'Biography must be between 0 to 2000 characters.'
			)
		),
		'old_password' => array
		(
	        'rule' => 'checkCurrentPassword',
	        'message' => 'Wrong password.',
	        'required' => true
	    ),
		'new_password' => array
		(
			'between' => array(
				'rule' => array('lengthBetween', 5, 16),
				'message' => 'Your password must be between 5 and 16 characters long.',
				'required' => true
			),
			'matchPassword' => array(
				'rule' => 'matchPasswords',
				'message' => 'Your passwords do not match!',
				'required' => true
			)
		),
		'confirm_password' => array
		(
			'between' => array(
				'rule' => array('lengthBetween', 5, 16),
				'message' => 'Your password must be between 5 and 16 characters long.',
				'required' => true
			)
		)
	);
	
	public function checkCurrentPassword($data) {
	    $this->id = AuthComponent::user('id');
	    $password = $this->field('password');
	    return (AuthComponent::password($data['Profile']['current_password']) == $password);
	}
	
	/* Checks if the password and password2 field contain the same password.
	 - Used for the match passwords validation check. 
	*/
    public function matchPasswords($data) {
        if ($data['new_password'] == $this->data['Profile']['confirm_password']) {
            return true;
        }
        $this->invalidate('confirm_password', 'Your passwords do not match.');
        return false;
    }

}
?>
