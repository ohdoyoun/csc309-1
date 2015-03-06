<?php
class ProjectsController extends AppController {
	
	public $name = 'Projects';


	function index() {
		$this->set('projects', $this->Project->find('all'));
	}
    
    function view($id = NULL) {
        $this->set('project', $this->Project->find('first', array('conditions' => array('Project.id' => $id))));    
    }
    
    function mine() {
        $this->set('mine', $this->Project->Initiator->find('all', array('conditions' => array('Initiator.id' => $this->Auth->user('id')))));
    }
    
    function backed() {
        $this->set('backed', $this->Project->query("SELECT project_id FROM transactions WHERE user_id=" . $this->Auth->user('id')));
    }
    
    function create() {
        if (!empty($this->data)) {
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

            if ($this->Project->saveAll($new_project_data, array('deep' => true))) { 
                
                $user_id = $this->Auth->user('id'); 
                $project_id = $this->Project->find('first', array('conditions' => array('Project.project_name' => $project_name)))['Project']['id'];
                
                $new_initiator_data = array(
                	'Initiator' => array(
                		'project_id' => $project_id,
                		'user_id' => $user_id
                	)
                );
                
                $this->Project->Initiator->add($new_initiator_data);
                
                if ($this->Project->Initiator->saveAll($new_initiator_data, array('deep' => true))) {
                    $this->Session->setFlash('Project Created.');
                    $this->redirect(array('action'=>'index'));
                }
                
            }
        }
    }
}
