<?php

class User extends AppModel {

	var $name = 'User';

	var $validate = array
        (
            'username' => array
            (
                'alphaNumeric' => array
                (
                    'rule' => 'alphaNumeric',
                    'required' => true,
                    'message' => 'Your username may only be alphanumeric characters.'
                ),
                'between' => array
                (
                    'rule' => array('lengthBetween', 1, 25),
                    'message' => 'Username must be between 1 to 25 characters.'
                ),
                'unique' => array(
                    'rule' => 'isUnique',
                    'required' => true,
                    'allowEmpty' => false,
                    'on' => 'create',
                    'last' => false,
                    'message' => 'Username already exists!'
                )
            ), 
            'password' => array
            (
                'between' => array
                (
                    'rule' => array('lengthBetween', 5, 16),
                    'message' => 'Password must be between 5 to 16 characters.'
                ),
                'Match PW'=>array(
                    'rule'=>'matchPasswords',
                    'message'=>'Your passwords do not match.'
                )                
            ),
            'password_confirmation' => array
            (
                'between' => array
                (
                    'rule' => array('lengthBetween', 5, 16),
                    'message' => 'Password must be between 5 to 16 characters.'
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
                    'on' => 'create',
                    'last' => false,
                    'message' => 'E-mail already exists!'
                ),
                'email' => 'email'                
            )  
        );
    
    public function matchPasswords($data) {
        if ($data['password'] == $this->data['User']['password_confirmation']) {
            return true;
        }
        $this->invalidate('password_confirmation', 'Your passwords do not match.');
        return false;
    }
    
    public function beforeSave($options=array()) {
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);   
        }
        return true;
    }
}