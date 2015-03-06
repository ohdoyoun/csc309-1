<?php
class ProjectsController extends AppController {
	
	public $name = 'Projects';


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
            $project_name = $this->request->data['Project']['project_name'];
            $goal = $this->request->data['Project']['goal'];
            $end_date = $this->request->data['Project']['end_date'];
            $details = $this->request->data['Project']['details'];
            
            $new_project_data = array(
            	'Project' => array(
            		'project_name' => $project_name,
            		'goal' => $goal,
            		'end_date' => $end_date,
            		'details' => $details
            	)
            );
            
            $this->Project->add($new_project_data);
            
            $user_id = $this->Auth->user('id'); 
            $project_id = $this->Project->find('first', array(
            	'conditions' => array('project_name' => $project_name),
            	'fields' => array('id')
            	)
            );
            
            $new_initiator_data = array(
            	'Initiator' => array(
            		'project_id' => $project_id,
            		'user_id' => $user_id
            	)
            );
            
            $this->Project->Initiator->add($new_initiator_data);

            if ($this->Project->saveAll($this->data, array('deep' => true))) {            
                $this->Session->setFlash('Project Created.');
                $this->redirect(array('action'=>'index'));
            }
        }
    }
    

}
