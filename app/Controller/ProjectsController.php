<?php
class ProjectsController extends AppController {
	
	public $name = 'Projects';

    public function beforeFilter() {
        parent::beforeFilter(); 
        if (!($this->Auth->user())) {
            $this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
        }
        
    }
    

	function index() {
		$this->set('projects', $this->Project->find('all'));
	}
    
    function view($id = NULL) {
        $this->set('project', $this->Project->find('first', array('conditions' => array('Project.id' => $id))));  

        $this->set('current_amount', $this->Project->query('SELECT sum(funds) as total FROM transactions WHERE project_id=' . $id . ' GROUP BY project_id;'));
        
        if (!empty($this->data)) {
            debug($this->data);
            if (preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $this->data['Project']['Amount'])) {
                if (floatval($this->data['Project']['Amount']) <= floatval($this->Project->query('SELECT sum(total) as total FROM (SELECT sum(funds) as total, user_id FROM wallets, wallet_transactions where wallet_id=wallets.id and user_id=' . $this->Auth->user('id') . ' GROUP BY user_id UNION SELECT sum(funds) * -1 as total, user_id FROM transactions where user_id=' . $this->Auth->user('id') . ' GROUP BY user_id) as info GROUP BY user_id;')[0][0]['total'])) {
                    $this->Project->query('INSERT INTO transactions (project_id, user_id, funds) VALUES (' . $id . ', ' . $this->Auth->user('id') . ', ' . floatval($this->data['Project']['Amount']) . ');');
                    $this->Session->setFlash('Funded project successfully.');
                } else {
                    $this->Session->setFlash('Not enough funds.');
                }
            } else {
                $this->Session->setFlash('Invalid amount.');
            }
        }
    }
    
    function mine() {
        $this->set('mine', $this->Project->query('SELECT * FROM projects, initiators WHERE initiators.user_id=' . $this->Auth->user('id') . ' and initiators.project_id=projects.id;'));
    }
    
    function backed() {
        $this->set('backed', $this->Project->query("SELECT project_id FROM transactions WHERE user_id=" . $this->Auth->user('id') . " GROUP BY project_id;"));
    }
    
    function search() {
        
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
