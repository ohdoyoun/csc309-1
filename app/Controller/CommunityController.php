<?php
class ControllerController extends AppController {
  
  public $name = 'Community';
  
  function index(){
    $this->set('communities', $name->find('all'));
  }
  
  
  

}
?>
