<?php

class Account extends AppModel {

	public $name = 'Account';
    public $useTable = 'users';
    
    public $validate = array
        (
            'first_name' => array
            (
                'alphaNumeric' => array
                (
                    'rule' => 'alphaNumeric',
                    'required' => true,
                    'message' => 'Your first name may only be alphanumeric characters.'
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
                    'message' => 'Your first name may only be alphanumeric characters.'
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
                    'message' => 'Country may only be alphanumeric characters.'
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
                    'message' => 'Province may only be alphanumeric characters.'
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
                    'message' => 'City may only be alphanumeric characters.'
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
                    'message' => 'Address may only be alphanumeric characters.'
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
                    'message' => 'Postal code may only be alphanumeric characters.'
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
                    'message' => 'Phone number may only be alphanumeric characters.'
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
                    'message' => 'Biography may only be alphanumeric characters.'
                ),
                'between' => array
                (
                    'rule' => array('lengthBetween', 0, 2000),
                    'message' => 'Biography must be between 0 to 2000 characters.'
                )
            ),
        );
}