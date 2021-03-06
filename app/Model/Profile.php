<?php 
App::uses('AppModel', 'Model');
class Profile extends AppModel{
	
	// The name of this Model.
	public $name = 'Profile';
	
	// The table that this Model is linked to.
	public $useTable = 'profiles';

	// The association to the User Model.
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
	);

	/* The associations that linked this Model to other Models.
	- Linked to MacroTag and MicroTag models.
	*/
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

	// The rules this model uses to validate.
 	public $validate = array(
		'first_name' => array
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
				'rule' => 'isValidPhoneFormat',
				'required' => true,
				'message' => 'Please enter a valid phone number.',
                'allowEmpty' => true
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 10),
				'message' => 'Phone number must be between 1 to 10 characters.'
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
    
    /*isValidPhoneFormat() - Custom method to validate Phone Number
	 * @params Int $phone
	 */
	 function isValidPhoneFormat($phone){
	 $phone_no=$phone['phone_num'];
	 $errors = array();
	    if(empty($phone_no)) {
	        $errors [] = "Please enter Phone Number";
	    }
	    else if (!preg_match('/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s.]{0,1}[0-9]{3}[-\s.]{0,1}[0-9]{4}$/', $phone_no)) {
	        $errors [] = "Please enter valid Phone Number";
	    } 
	
	    if (!empty($errors))
	    return implode("\n", $errors);
	
	    return true;
	}


}
?>
