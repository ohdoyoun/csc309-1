<?php 
App::import('Tag','Model'); 
class MicroTag extends Tag{
	
	public var $name = 'MicroTag';
	
	public var $useTable = 'micro_tags';

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
	
	public function lookUpProjects($tag_name, $like=true){
		var $options['joins'] = array(
			array(
				'table' => 'project_micro_tags',
				'alias' => 'ProjectMicroTag',
				'type' => 'inner',
				'conditions' => array(MicroTag.id = ProjectMicroTag.micro_tag_id)
			),
			array(
				'table' => 'projects',
				'alias' => 'Project',
				'type' => 'inner',
				'conditions' => array(ProjectMicroTag.project_id = Project.id)
			)
		);
		if($like){
			$options['conditions'] = array('MicroTag.name LIKE' => $tag_name);
		}else{
			$options['conditions'] = array('MicroTag.name' => $tag_name);
		}
		return $this->find('all', $options);
	}
	
	public function lookUpProfiles($tag_name, $like=true){
		var $options['joins'] = array(
			array(
				'table' => 'profile_micro_tags',
				'alias' => 'ProfileMicroTag',
				'type' => 'inner',
				'conditions' => array(MicroTag.id = ProfileMicroTag.micro_tag_id)
			),
			array(
				'table' => 'profiles',
				'alias' => 'Profile',
				'type' => 'inner',
				'conditions' => array(ProfileMicroTag.profile_id = Profile.id)
			)
		);
		if($like){
			$options['conditions'] = array('MicroTag.name LIKE' => $tag_name);
		}else{
			$options['conditions'] = array('MicroTag.name' => $tag_name);
		}
		return $this->find('all', $options);
	}

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
