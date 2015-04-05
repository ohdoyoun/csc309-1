<?php
class CommunitiesController extends AppController {
  
  public $name = 'Communities';
  
  public function index(){
    $this->set('communities', $this->Community->query('SELECT * FROM communities, micro_tags, macro_tags WHERE communities.macro_tag_id=macro_tags.id and communities.micro_tag_id=micro_tags.id;'));
  }
  
  public function view($id = null) {
    if($id != null){
      $this->set('posts', $this->Post->find('all', 'conditions' => array('Post.communities_id' => $id)));
      $community = $this->Community->findById($id);
      $this->set('message', $community['name']);
    }else{
      $this->set('message'. 'Could not find this Community!');
      $this->set('posts', null);
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
  private function help_search($tag_name, $profiles=true, $projects=true, $tag_flag=0){
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
  }
  
  /* Implements the search functionality. 
  Able to search for projects and profiles within the communties using Macro Tags and Micro Tags.
  */
  public function search() {
    $item_options = ['Profiles', 'Projects', 'All'];
    $tag_options = ['Communities', 'Sub-Communities', 'All'];
    if (!empty($this->data)) {
      if (strlen($this->data['Communities']['tag_name']) > 0){
        $this->set('tag_name', $this->data['Communities']['tag_name']);
        $item = $this->data['Communities']['category'];
        $tag = $this->data['Communities']['community'];
        if(in_array($item, $item_options) && in_array($tag, $tag_options)){
          switch($item){
            case 'Profiles':
              $this->set('profiles', true);
              $this->set('projects', false);
            case 'Projects':
              $this->set('profiles', false);
              $this->set('projects', true);
            default:
              $this->set('profiles', true);
              $this->set('projects', true);
          }
          switch($tag){
            case 'Communities':
              $this->set('tag_flag', 1);
            case 'Sub-Communities':
              $this->set('tag_flag', 2);
            default:
              $this->set('tag_flag', 0);
          }
          $this->redirect(array('controller'=>'communities', 'action'=>'results'));
        }
      }
    }
    
  }
  
  
  
}
?>
