<?php
class ProjectsController extends AppController {
	
	var $name = 'Projects';


	function index() {
		$this->set('projects', $this->Project->find('all'));
	}
    
    function create() {
        if (!empty($this->data)) {
            $this->Project->set('user_id', $this->Auth->user('id'));
            $this->Project->set('status_tag_id', 0);
            if ($this->Project->save($this->data)) {
                $this->Session->setFlash('Project Created.');
                $this->redirect(array('action'=>'index'));
            }
        }
    }
    

}