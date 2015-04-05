<?php
class CommunitiesController extends AppController {
  
  public $name = 'Communities';
  
  public function index(){
    $this->set('communities', $this->Community->query('SELECT * FROM communities, micro_tags, macro_tags WHERE communities.macro_tag_id=macro_tags.id and communities.micro_tag_id=micro_tags.id;'));
  }
  
  public function view($id = null) {
    
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
      return array_merge($this->MacroTag->lookup($tag_name, $profiles, $projects), $this->MicroTag->lookup($tag_name, $profiles, $projects));
    }
    if($tag_flag==1){
      return $this->MacroTag->lookup($tag_name, $profiles, $projects);
    }
    if($tag_flag==2){
      return $this->MicroTag->lookup($tag_name, $profiles, $projects)
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
        $tag_name = $this->data['Communities']['tag_name'];
        $item = $this->data['Communities']['category'];
        $tag = $this->data['Communities']['community'];
        if(in_array($item, $item_options) && in_array($tag, $tag_options)){
          switch($item){
            case 'Profiles':
              $profiles = true;
              $projects = false;
            case 'Projects':
              $profiles = false;
              $projects = true;
            default:
              $profiles = true;
              $projects = true;
          }
          switch($tag){
            case 'Communities':
              return help_search($tag_name, $profiles, $projects, 1);
            case 'Sub-Communities':
              return help_search($tag_name, $profiles, $projects, 2);
            default:
              return help_search($tag_name, $profiles, $projects);
          }
        }
      }
    }
    
  }
  
  
  

}
?>
