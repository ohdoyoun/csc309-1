<?php
class CommunityController extends AppController {
  
  public $name = 'Community';
  
  public function index(){
    $this->set('communities', $this->Community->find('all'));
  }
  
  
  

}
?>
