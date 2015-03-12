<?php 
App::uses('Tag','Model'); 
class MicroTag extends Tag{
	
	public $name = 'MicroTag';
	
	public $useTable = 'micro_tags';

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
	
	private function lookUpProjects($tag_name, $like=true){
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
	
	private function lookUpProfiles($tag_name, $like=true){
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
