<?php
class CommunitiesController extends AppController {
  
  public $name = 'Communities';
  
  public function index(){
    $this->set('communities', $this->Community->query('SELECT * FROM communities, micro_tags, macro_tags WHERE communities.macro_tag_id=macro_tags.id and communities.micro_tag_id=micro_tags.id;'));
  }
  
  public function view($id = null) {
    if($id != null){
      if ($this->Community->query('SELECT count(*) FROM communities WHERE id=' . $id . ';')[0][0]['count(*)'] > 0) {
        $this->set('posts', $this->Community->query('SELECT * FROM posts, users WHERE posts.user_id=users.id and community_id=' . $id . ';'));
        $macro_tag = $this->Community->query('SELECT * FROM communities, macro_tags WHERE communities.macro_tag_id=macro_tags.id and communities.id=' . $id . ';')[0]['macro_tags']['name'];
        $micro_tag = $this->Community->query('SELECT * FROM communities, micro_tags WHERE communities.micro_tag_id=micro_tags.id and communities.id=' . $id . ';')[0]['micro_tags']['name'];
        $message = $macro_tag . " : " . $micro_tag;
        $this->set('message', $message);
        
      } else {
        $this->set('message', 'Could not find this Community!');
        $this->set('posts', null);
      }
    }
  }
  
  public function results(){
    help_search($tag_name, $profiles, $projects, $tag_flag);
  }
  
  public function create() {
    $tags = $this->Community->query('SELECT * FROM macro_tags;');
    
    $cleanedTags = array();
    
    foreach($tags as $tag):
      $cleanedTags[$tag['macro_tags']['id']] = $tag['macro_tags']['name'];
    endforeach;
    
    $this->set('macroTags', $cleanedTags);
    
    if (!empty($this->data)) {
      if (strlen($this->data['Communities']['title']) > 0 and strlen($this->data['Communities']['title']) <= 50) {
        if ($this->Community->query('SELECT count(*) as total FROM micro_tags WHERE name=\'' . $this->data['Communities']['title'] . '\';')[0][0]['total'] == 0) {
          $this->Community->query('INSERT INTO micro_tags (name) VALUES (\'' . $this->data['Communities']['title'] . '\');');
          $insertID = $this->Community->query('SELECT id FROM micro_tags WHERE name=\'' . $this->data['Communities']['title'] . '\';')[0]['micro_tags']['id'];
          $this->Community->query('INSERT INTO communities (macro_tag_id, micro_tag_id) VALUES (' . $this->data['Communities']['category'] . ', ' . $insertID . ');');
          $this->Session->setFlash('Community created!');
          $this->redirect(array('controller'=>'communities', 'action'=>'index'));
        } else {
          $this->Session->setFlash('Title already exists');
          $this->redirect(array('controller'=>'communities', 'action'=>'create'));
        }
      } else {
        $this->Session->setFlash('Title must be in between 1 and 50 characters');
        $this->redirect(array('controller'=>'communities', 'action'=>'create'));
      }
    }
  }
  
  /* Helper function. Returns the lookup function on Macro Tags, Micro Tags or both.
  $tag_flag possible options:
    0 = Perform the lookup function on both Macro Tags and Micro Tags.
    1 = Perform the lookup function on just the Macro Tags.
    2 = Perform the lookup function on just the Micro Tags.
  */
  /*private function help_search($tag_name, $profiles=true, $projects=true, $tag_flag=0){
    if($tag_flag==0){
      if($profiles){
        $this->set('macro_profiles', $this->MacroTag->lookUpProfiles($tag_name));
        $this->set('micro_profiles', $this->MicroTag->lookUpProfiles($tag_name));
      }
      if($projects){
        $this->set('macro_projects', $this->MacroTag->lookUpProjects($tag_name));
        $this->set('micro_projects', $this->MicroTag->lookUpProjects($tag_name));
      }
    }
    if($tag_flag==1){
      if($profiles){
        $this->set('macro_profiles', $this->MacroTag->lookUpProfiles($tag_name));
        $this->set('micro_profiles', null);
      }
      if($projects){
        $this->set('macro_projects', $this->MacroTag->lookUpProjects($tag_name));
        $this->set('micro_projects', null);
      }
    }
    if($tag_flag==2){
      if($profiles){
        $this->set('macro_profiles', null);
        $this->set('micro_profiles', $this->MicroTag->lookUpProfiles($tag_name));
      }
      if($projects){
        $this->set('macro_projects', null);
        $this->set('micro_projects', $this->MicroTag->lookUpProjects($tag_name));
      }
    }
  }*/
	/* Looks up the projects with a given macro tag name.
	- Private function to be used by the public lookUp function.
	*/
	private function lookUpProjectsMacro($tag_name, $like=true){
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
		return ClassRegistry::init('MacroTag')->find('all', $options);
	}
	
	/* Looks up the profiles with a given macro tag name.
	- Private function to be used by the public lookUp function.
	*/
	private function lookUpProfilesMacro($tag_name, $like=true){
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
		return ClassRegistry::init('MacroTag')->find('all', $options);
	}

	/* Looks up the projects with a given micro tag name.
	- Private function to be used by the public lookUp function.
	*/
	public function lookUpProjectsMicro($tag_name, $like=true){
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
		return ClassRegistry::init('MicroTag')->find('all', $options);
	}
	
	/* Looks up the profiles with a given micro tag name.
	- Private function to be used by the public lookUp function.
	*/
	public function lookUpProfilesMicro($tag_name, $like=true){
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
		return ClassRegistry::init('MicroTag')->find('all', $options);
	}
  
  /* Implements the search functionality. 
  Able to search for projects and profiles within the communties using Macro Tags and Micro Tags.
  */
  public function search() {
    $item_options = [0, 1, 2];
    $tag_options = [0, 1, 2];
    if (!empty($this->data)) {
      if (strlen($this->data['Communities']['tag_name']) > 0){
        $tag_name = $this->data['Communities']['tag_name'];
        $item = $this->data['Communities']['category'];
        $tag = $this->data['Communities']['community'];
        if(in_array($item, $item_options) && in_array($tag, $tag_options)){
          if ($item == 0) {
            $profiles = true;
            $projects = false;
          } elseif ($item == 1) {
            $profiles = false;
            $projects = true;
          } else {
            $profiles = true;
            $projects = true;
          }
          
          if ($tag == 0) {
            $tag_flag = 1;
          } elseif ($tag == 1) {
            $tag_flag = 2;
          } else {
            $tag_flag = 0;
          }

          if($tag_flag==0){
            if($profiles){
              $this->set('macro_profiles', $this->lookUpProfilesMacro($tag_name));
              $this->set('micro_profiles', $this->lookUpProfilesMicro($tag_name));
            }
            if($projects){
              $this->set('macro_projects', $this->lookUpProjectsMacro($tag_name));
              $this->set('micro_projects', $this->lookUpProjectsMicro($tag_name));
            }
          }
          if($tag_flag==1){
            if($profiles){
              $this->set('macro_profiles', $this->lookUpProfilesMacro($tag_name));
              $this->set('micro_profiles', null);
            }
            if($projects){
              $this->set('macro_projects', $this->lookUpProjectsMacro($tag_name));
              $this->set('micro_projects', null);
            }
          }
          if($tag_flag==2){
            if($profiles){
              $this->set('macro_profiles', null);
              $this->set('micro_profiles', $this->lookUpProfilesMicro($tag_name));
            }
            if($projects){
              $this->set('macro_projects', null);
              $this->set('micro_projects', $this->lookUpProjectsMacro($tag_name));
            }
          }
        }
      } else {
        $this->Session->setFlash('Please fill out the field Tag Name');
      }
    }
    
  }
  
  
  
}
?>
