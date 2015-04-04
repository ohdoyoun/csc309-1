<?php 
App::uses('AppModel', 'Model');
class Community extends AppModel{
	
	// The table to use.
	public $useTable = 'communities';
	
	// The name of the Model.
	public $name = 'Community';
	
	public $hasMany = array(
		'Post' => array(
			'className' => 'Post',
			'dependent' => true
			)
		);
	
	/* The validation rules that this model must follow. 
	- Mostly dervived from the database.
	*/
	public $validate = array(
		'title' => array(
			'alphaNumeric' =>array(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Your title may only be alpha-numeric characters.'
			),
			'between' => array(
				'rule' => array('lengthBetween', 1, 50),
				'message' => 'Title must be between 1 to 50 characters.'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'required' => true,
				'allowEmpty' => false,
				'on' => 'create',
				'last' => false,
				'message' => 'That title already exists! Please choose another title.'
			)
		)
	);	
}
?>
