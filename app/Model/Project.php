<?php 
class Project extends AppModel{
	
	public $hasMany = array(
		'StatusTag' => array(
			'className' => 'StatusTag',
			'dependent' => true
		)
	);

	public $hasAndBelongsToMany = array(
		'Project' => array(
			'className' => 'Project',
			'joinTable' => 'initiators',
			'with' => 'Initiator',
			'foreignKey' => 'project_id',
			'associationForeignKey' => 'profile_id'
		),
		'MacroTag' => array(
			'className' => 'MacroTag',
			'joinTable' => 'projects_macro_tags',
			'with' => 'ProjectsMacroTag',
			'foreignKey' => 'project_id',
			'associationForeignKey' => 'macro_tag_id'
		),
		'MicroTag' => array(
			'className' => 'MicroTag',
			'joinTable' => 'projects_micro_tags',
			'with' => 'ProjectsMicroTag',
			'foreignKey' => 'project_id',
			'associationForeignKey' => 'micro_tag_id'
		)
	);

	public $validate = array(
		'project_name' => array(
			'alphaNumeric' => array
			(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Project names may only be alphanumeric characters.'
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 50),
				'message' => 'Project name must be between 1 to 50 characters.'
			)
		),
		'goal' => array(
			'rule' => array('money', 'left'),
			'required' => true,
			'message' => 'Please supply a valid monetary amount.'
		),
		'start_date' => array(
			'rule' => 'date',
			'required' => true,
			'message' => 'Projects require a start date.'
		),
		'end_date' => array(
			'rule' => 'date',
			'required' => true,
			'message' => 'Projects require an end date.'
		),
		'valid_dates' => array(
			'rule' => 'checkDates',
			'message' => 'The end date must be later than the start date.'
		),
		'details' => array(
			'alphaNumeric' => array
			(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Project details may only contain alphanumeric characters.'
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 75),
				'message' => 'Project details must be between 1 to 75 characters.'
			)
			
		)
	);
	/* Checks if the start date is before the end date.
	- Used for validation check.
	*/
	public function checkDates($data){
		if((isset($this->data[$this->alias]['start'])) &&(isset($this->data[$this->alias]['end']))){
			return $this->data[$this->alias]['start'] < $this->data[$this->alias]['end'];
		}
		return true;
	}

}
?>
