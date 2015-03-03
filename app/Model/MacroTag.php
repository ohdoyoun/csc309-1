<?php 
App::import('Tag', 'Model'); 
class MacroTag extends Tag{
	
	public var $name = 'MacroTag';
	
	public var $useTable = 'macro_tags';

	public var $hasAndBelongsToMany = array(
		'MicroTag' => array(
			'className' => 'MicroTag',
			'joinTable' => 'communities',
			'with' => 'Community',
			'foreignKey' => 'macro_tag_id',
			'associationForeignKey' => 'micro_tag_id'
		),
		'Project' => array(
			'className' => 'Project',
			'joinTable' => 'projects_macro_tags',
			'with' => 'ProjectsMacroTag',
			'foreignKey' => 'macro_tag_id',
			'associationForeignKey' => 'project_id'
		),
		'Profile' => array(
			'className' => 'Profile',
			'joinTable' => 'profiles_macro_tags',
			'with' => 'ProfilesMacroTag',
			'foreignKey' => 'macro_tag_id',
			'associationForeignKey' => 'profile_id'
		)
	);

	public var $actAs = array( 'Inherit' );
	
	public function lookUpProjects($tag_name, $like=true){
		var $options['joins'] = array(
			array(
				'table' => 'project_macro_tags',
				'alias' => 'ProjectMacroTag',
				'type' => 'inner',
				'conditions' => array(MacroTag.id = ProjectMacroTag.macro_tag_id)
			),
			array(
				'table' => 'projects',
				'alias' => 'Project',
				'type' => 'inner',
				'conditions' => array(ProjectMacroTag.project_id = Project.id)
			)
		);
		if($like){
			$options['conditions'] = array('MacroTag.name LIKE' => $tag_name);
		}else{
			$options['conditions'] = array('MacroTag.name' => $tag_name);
		}
		return $this->find('all', $options);
	}
	
	public function lookUpProfiles($tag_name, $like=true){
		var $options['joins'] = array(
			array(
				'table' => 'profile_macro_tags',
				'alias' => 'ProfileMacroTag',
				'type' => 'inner',
				'conditions' => array(MacroTag.id = ProfileMacroTag.macro_tag_id)
			),
			array(
				'table' => 'profiles',
				'alias' => 'Profile',
				'type' => 'inner',
				'conditions' => array(ProfileMacroTag.profile_id = Profile.id)
			)
		);
		if($like){
			$options['conditions'] = array('MacroTag.name LIKE' => $tag_name);
		}else{
			$options['conditions'] = array('MacroTag.name' => $tag_name);
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
				'message' => 'Tag names must be between 1 to 75 characters.'
			)
			
		)
	);
	*/
}
?>
