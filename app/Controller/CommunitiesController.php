<?php
class CommunitiesController extends AppController {
  
  public $name = 'Communities';
  
  public function index(){
    #$this->set('communities', $this->Community->query('SELECT '));
  }
  
  public function create() {
    $tags = $this->Community->query('SELECT * FROM macro_tags;');
    
    $cleanedTags = array();
    
    foreach($tags as $tag):
      $cleanedTags[$tag['macro_tags']['id']] = $tag['macro_tags']['name'];
    endforeach;
    
    $this->set('macroTags', $cleanedTags);
  }
  
  public function search() {
    
  }
  
  
  

}
?>
