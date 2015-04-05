<?php 
App::uses('Tag','Model'); 
class MicroTag extends Tag{
	
	// The name this Model.
	public $name = 'MicroTag';
	
	// The table that this Model uses.
	public $useTable = 'micro_tags';

	/* The associations to that link this Model has to other Models.
	- The Models linked to this Model are MacroTag, Project and Profile.
	*/
	public $hasAndBelongsToMany = array(
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

	// The Inheritance property.
	public $actAs = array( 'Inherit' );
	
	/* Looks up profiles and/or projects with a given tag.
	- Uses the private functions lookUpProfiles and lookUpProjects
	
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
	*/
	
	/* Looks up the projects with a given micro tag name.
	- Private function to be used by the public lookUp function.
	*/
	public function lookUpProjects($tag_name, $like=true){
		$options['joins'] = array(
			array(
				'table' => 'project_micro_tags',
				'alias' => 'ProjectMicroTag',
				'type' => 'inner',
				'conditions' => array('MicroTag.id' => 'ProjectMicroTag.micro_tag_id')
			),
			array(
				'table' => 'projects',
				'alias' => 'Project',
				'type' => 'inner',
				'conditions' => array('ProjectMicroTag.project_id' => 'Project.id')
			)
		);
		if($like){
			$options['conditions'] = array('MicroTag.name LIKE' => $tag_name);
		}else{
			$options['conditions'] = array('MicroTag.name' => $tag_name);
		}
		return $this->find('all', $options);
	}
	
	/* Looks up the profiles with a given micro tag name.
	- Private function to be used by the public lookUp function.
	*/
	public function lookUpProfiles($tag_name, $like=true){
		$options['joins'] = array(
			array(
				'table' => 'profile_micro_tags',
				'alias' => 'ProfileMicroTag',
				'type' => 'inner',
				'conditions' => array('MicroTag.id' => 'ProfileMicroTag.micro_tag_id')
			),
			array(
				'table' => 'profiles',
				'alias' => 'Profile',
				'type' => 'inner',
				'conditions' => array('ProfileMicroTag.profile_id' => 'Profile.id')
			)
		);
		if($like){
			$options['conditions'] = array('MicroTag.name LIKE' => $tag_name);
		}else{
			$options['conditions'] = array('MicroTag.name' => $tag_name);
		}
		return $this->find('all', $options);
	}

	/* Validates that name of the micro tag.
	- Depreciated. Global $validate takes care of this due to Inheritance.
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
