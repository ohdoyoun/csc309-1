<?php 
App::uses('Tag', 'Model'); 
class MacroTag extends Tag{
	
	// The name of the Model.
	public $name = 'MacroTag';
	
	// The table that this Model is linked to.
	public $useTable = 'macro_tags';

	/* The associations to that link this Model has to other Models.
	- The Models linked to this Model are MicroTag, Project and Profile.
	*/
	public $hasAndBelongsToMany = array(
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

	// Inheritance property.
	public $actAs = array( 'Inherit' );
	
	/* Looks up profiles and/or projects with a given tag.
	- Uses the private functions lookUpProfiles and lookUpProjects
	*/
	public function lookUp($tag_name, $profile=true, $project=true, $like=true){
		if($profile && !$project){
			return lookUpProfile($tag_name, $like);
		}
		elseif($project && !$profile){
			return lookUpProjects($tag_name, $like);
		}elseif($project && $profile){
			return array_merge(lookUpProfiles($tag_name, $like), lookUpProects($tag_name, $like));
		}else{
			return [];
		}
	}
	
	/* Looks up the projects with a given macro tag name.
	- Private function to be used by the public lookUp function.
	*/
	private function lookUpProjects($tag_name, $like=true){
		$options['joins'] = array(
			array(
				'table' => 'project_macro_tags',
				'alias' => 'ProjectMacroTag',
				'type' => 'inner',
				'conditions' => array('MacroTag.id' => 'ProjectMacroTag.macro_tag_id')
			),
			array(
				'table' => 'projects',
				'alias' => 'Project',
				'type' => 'inner',
				'conditions' => array('ProjectMacroTag.project_id' => 'Project.id')
			)
		);
		if($like){
			$options['conditions'] = array('MacroTag.name LIKE' => $tag_name);
		}else{
			$options['conditions'] = array('MacroTag.name' => $tag_name);
		}
		return $this->find('all', $options);
	}
	
	/* Looks up the profiles with a given macro tag name.
	- Private function to be used by the public lookUp function.
	*/
	private function lookUpProfiles($tag_name, $like=true){
		$options['joins'] = array(
			array(
				'table' => 'profile_macro_tags',
				'alias' => 'ProfileMacroTag',
				'type' => 'inner',
				'conditions' => array('MacroTag.id' => 'ProfileMacroTag.macro_tag_id')
			),
			array(
				'table' => 'profiles',
				'alias' => 'Profile',
				'type' => 'inner',
				'conditions' => array('ProfileMacroTag.profile_id' => 'Profile.id')
			)
		);
		if($like){
			$options['conditions'] = array('MacroTag.name LIKE' => $tag_name);
		}else{
			$options['conditions'] = array('MacroTag.name' => $tag_name);
		}
		return $this->find('all', $options);
	}

	
	/* Validates that name of the macro tag.
	- Depreciated. Global $validate takes care of this due to Inheritence.
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
