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
            var $project_name = $this->request->data['Project']['project_name'];
            var $goal = $this->request->data['Project']['goal'];
            var $end_date = $this->request->data['Project']['end_date'];
            var $details = $this->request->data['Project']['details'];
            
            var $new_project_data = array(
            	'Project' => array(
            		'project_name' => $project_name,
            		'goal' => $goal,
            		'end_date' => $end_date,
            		'details' => $details
            	)
            );
            
            $this->Project->add($new_project_data);
            
            var $user_id = $this->Auth->user('id'); 
            var $project_id = $this->Project->find('first', array(
            	'conditions' => array('project_name' => $project_name),
            	'fields' => array('id')
            	)
            );
            
            var $new_initiator_data = array(
            	'Initiator' => array(
            		'project_id' => $project_id,
            		'user_id' => $user_id
            	)
            );
            
            $this->Initiator->add($new_initiator_data);

            
            debug($this->data);
            if ($this->Project->saveAll($this->data, array('deep' => true))) {            
                $this->Session->setFlash('Project Created.');
                $this->redirect(array('action'=>'index'));
            }
        }
    }
    

}
