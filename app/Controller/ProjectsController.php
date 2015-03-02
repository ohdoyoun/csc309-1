<?php
class ProjectsController extends AppController {
	
	var $name = 'Projects';


	function index() {
		$this->set('projects', $this->Project->find('all'));
	}
    
    function view($id = NULL) {
        $this->set('project', $this->Project->find('first', array('conditions' => array('project.id' => $id))));    
    }
    
    function create() {
        if (!empty($this->data)) {
            
            
            
            #$this->Project->set('user_id', $this->Auth->user('id'));
            
            #Status tag 0 = beginning
            $this->request->data['Project']['status_tag_id'] = 0;
            $this->request->data['Project']['user_id'] = $this->Auth->user('id'); 
            $this->request->data['Initiator']['user_id'] = $this->Auth->user('id'); 

            
            debug($this->data);
            if ($this->Project->saveAll($this->data, array('deep' => true))) {            
                $this->Session->setFlash('Project Created.');
                $this->redirect(array('action'=>'index'));
            }
        }
    }
    

}