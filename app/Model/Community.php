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
}
?>
