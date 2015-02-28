<?php 
App::import('Model','Tag'); 
class MicroTag extends Tag{

	public var $hasAndBelongsToMany = array(
		'MacroTag' => array(
			'className' => 'MacroTag',
			'joinTable' => 'communities',
			'with' => 'Community',
			'foreignKey' => 'micro_tag_id',
			'associationForeignKey' => 'macro_tag_id'
		),
		'Project' => array(
			'className' => 'Project',
			'joinTable' => 'projects_micro_tags',
			'with' => 'ProjectsMicroTag',
			'foreignKey' => 'micro_tag_id',
			'associationForeignKey' => 'project_id'
		),
		'Profile' => array(
			'className' => 'Profile',
			'joinTable' => 'profiles_micro_tags',
			'with' => 'ProfilesMacroTag',
			'foreignKey' => 'micro_tag_id',
			'associationForeignKey' => 'profile_id'
		)
	);

	public var $actAs = array( 'Inherit' );

	/* Global $validate takes care of this due to Inheritence.

	public var $validate = array(
		'name' => array(
			'alphaNumeric' => array
			(
				'rule' => 'alphaNumeric',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Tag names may only contain alphanumeric characters.'
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 50),
				'message' => 'Tag names must be between 1 to 50 characters.'
			)
			
		)
	);
	*/
}
?>
