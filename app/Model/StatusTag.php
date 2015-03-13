<?php 
App::uses('Tag','Model'); 
class StatusTag extends Tag{

	// Private array that holds the possible names of Status tags.
	private $status = array(
		'Active',
		'Completed',
		'Uncompleted',
		'Paused',
		'Cancelled'
	);
	
	// The name of this Model.
	public $name = 'StatusTag';
	
	// The table that this Model uses.
	public $useTable = 'status_tags';
	
	// The association that this Model has to the Project Model.
	public $hasMany = array(
		'Project' => array(
			'classname' => 'Project',
			'dependent' => true
		)
	);

	// The Inheritance property.
	public $actAs = array( 'Inherit' );

	// The validation rules that this Model uses.
	public $validate = array(
		'name' => array(
			#Global $validate takes care of this due to Inheritence.

			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Status Tag names may only contain alphanumeric characters.'
			),
			'between' => array(
				'rule' => array('lengthBetween', 1, 20),
				'message' => 'Status Tag names must be between 1 to 20 characters.'
			),
			'oneOf' => array(
				'rule' => 'oneOf',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Must be one of the designated Status Tag names.'
			)
			
		),
		'status_date' => array(
			'datetime' => array(
				'rule' => array('datetime', 'dmy'),
				'message' => 'Must be a datetime in the form \'dmy\'.'
			)
		)
	);

	/* Checks if the Status Tag names are one of the possible choices.
	- The choices are laid out in the array $status.
	*/
	public function oneOf($data){
		if(isset($this->data[$this->alias]['name'])){
			foreach($status as $i){
				if($this->data[$this->alias]['name'] == $i){
					return true;
				}
			}
			return false;
		}
		return true;
	}

}
?>
