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
  
  public function search() {
    
  }
  
  
  

}
?>
