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
		$this->set('current_amounts', $this->Project->query('SELECT sum(funds) as total, project_id FROM transactions GROUP BY project_id;'));
		
		
	}
    
    function view($id = NULL) {
        $this->set('project', $this->Project->find('first', array('conditions' => array('Project.id' => $id))));  
        $this->set('current_amount', $this->Project->query('SELECT sum(funds) as total FROM transactions WHERE project_id=' . $id . ' GROUP BY project_id;'));
        
        $fundedProject = $this->Project->query('SELECT count(*) as total FROM transactions WHERE project_id=' . $id . ' and user_id=' . $this->Auth->user('id') . ';')[0][0]['total'];
        $gaveTestimony = $this->Project->query('SELECT count(*) as total FROM testimonials WHERE project_id=' . $id . ' and user_id=' . $this->Auth->user('id') . ';')[0][0]['total'];
        
        if ($fundedProject >= 1 and $gaveTestimony == 0) {
            $this->set('canGiveTestimony', true);
        } else {
            $this->set('canGiveTestimony', false);
        }
        
        $this->set('testimonials', $this->Project->query('SELECT testimony, user_id, username FROM testimonials, users WHERE project_id=' . $id . ' and user_id=users.id;'));
        
        $this->set('backers', $this->Project->query('SELECT u.username, t.funds, u.id FROM transactions as t, users as u WHERE t.user_id=u.id and t.project_id=' . $id . ';'));
        
        if (!empty($this->data)) {
            if (isset($this->data['Project']['fund'])) {
                if(preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $this->data['Project']['Amount'])) {
                    if (floatval($this->data['Project']['Amount']) <= floatval($this->Project->query('SELECT sum(total) as total FROM (SELECT sum(funds) as total, user_id FROM wallets, wallet_transactions where wallet_id=wallets.id and user_id=' . $this->Auth->user('id') . ' GROUP BY user_id UNION SELECT sum(funds) * -1 as total, user_id FROM transactions where user_id=' . $this->Auth->user('id') . ' GROUP BY user_id) as info GROUP BY user_id;')[0][0]['total'])) {
                        $this->Project->query('INSERT INTO transactions (project_id, user_id, funds) VALUES (' . $id . ', ' . $this->Auth->user('id') . ', ' . floatval($this->data['Project']['Amount']) . ');');
                        $this->Session->setFlash('Funded project successfully.');
                        $this->redirect(array('controller'=>'projects', 'action'=>'view/' . $id));
                    } else {
                        $this->Session->setFlash('Not enough funds.');
                    }
                } else {
                    $this->Session->setFlash('Invalid amount.');
                }
            } elseif (isset($this->data['Project']['feedback'])) {
                if (strlen($this->data['Project']['Testimony']) > 0 and strlen($this->data['Project']['Testimony']) <= 1000) {
                    $this->Project->query('INSERT INTO testimonials (project_id, user_id, testimony) VALUES (' . $id . ', ' . $this->Auth->user('id') . ', \'' . $this->data['Project']['Testimony'] . '\');');
                    $this->Session->setFlash('Testimony added.');
                    $this->redirect(array('controller'=>'projects', 'action'=>'view/' . $id));
                } else {
                    $this->Session->setFlash('Testimony must be less than or equal to 1000 characters and not empty.');
                }
            } 
        }
    }
    
    function mine() {
        $this->set('mine', $this->Project->query('SELECT * FROM initiators, projects LEFT OUTER JOIN (SELECT sum(funds), project_id FROM transactions GROUP BY project_id) as funds ON (funds.project_id=projects.id) WHERE initiators.user_id=' . $this->Auth->user('id') . ' and initiators.project_id=projects.id;'));
    }
    
    function backed() {
        $this->set('backed', $this->Project->query("SELECT project_id, project_name, end_date, goal, sum(funds) FROM transactions, projects WHERE user_id=" . $this->Auth->user('id') . " and projects.id=transactions.project_id GROUP BY project_id;"));
    }
    
    function search() {
        
    }
    
    function statistics() {
        //Global stats
        $this->set('numberOfUsers', $this->Project->query('SELECT count(*) as total FROM users;'));
        $this->set('numberOfProfiles', $this->Project->query('SELECT count(*) as total FROM profiles;'));
        $this->set('numberOfProjects', $this->Project->query('SELECT count(*) as total FROM projects;'));
        $this->set('numberOfCommunities', $this->Project->query('SELECT count(*) as total FROM communities;'));
        $this->set('moneyInSystem', $this->Project->query('SELECT sum(funds) as total FROM wallet_transactions;'));
        $this->set('moneySpent', $this->Project->query('SELECT sum(funds) as total FROM transactions;'));
        $this->set('projectsBeingFunded', $this->Project->query('SELECT count(DISTINCT project_id) as total FROM transactions;'));
        $this->set('projectsNotBeingFunded', $this->Project->query('SELECT count(*) as total FROM projects;'));
        $this->set('projectsDone', $this->Project->query('SELECT count(*) as total FROM projects WHERE end_date <= current_timestamp;'));
        $this->set('projectsActive', $this->Project->query('SELECT count(*) as total FROM projects WHERE end_date >= current_timestamp;'));
        $this->set('projectsFullyFunded', $this->Project->query('SELECT count(*) as total FROM (SELECT sum(funds) as funded, p.id, p.goal FROM projects AS p, transactions AS t where t.project_id=p.id GROUP BY p.id) AS funds WHERE funded >= goal;'));
    
        //User stats
        $this->set('numberOfProjectsUser', $this->Project->query('SELECT count(*) as total FROM projects, initiators WHERE projects.id=initiators.project_id and initiators.user_id=' . $this->Auth->user('id') . ';'));
        $this->set('moneyRaised', $this->Project->query('SELECT sum(funds) as total FROM transactions as t, projects as p, initiators as i WHERE i.project_id=p.id and i.user_id=' . $this->Auth->user('id') . ' and t.project_id=p.id;'));
        $this->set('projectsBeingFundedUser', $this->Project->query('SELECT count(DISTINCT t.project_id) as total FROM transactions as t, projects as p, initiators as i WHERE i.project_id=p.id and i.user_id=' . $this->Auth->user('id') . ' and t.project_id=p.id;'));
        $this->set('projectsNotBeingFundedUser', $this->Project->query('SELECT count(*) as total FROM projects, initiators WHERE initiators.project_id=projects.id and initiators.user_id=' . $this->Auth->user('id') . ';'));
        $this->set('projectsDoneUser', $this->Project->query('SELECT count(*) as total FROM projects, initiators WHERE initiators.project_id=projects.id and initiators.user_id=' . $this->Auth->user('id') . ' and end_date <= current_timestamp;'));
        $this->set('projectsActiveUser', $this->Project->query('SELECT count(*) as total FROM projects, initiators WHERE initiators.project_id=projects.id and initiators.user_id=' . $this->Auth->user('id') . ' and end_date >= current_timestamp;'));
        $this->set('projectsFullyFundedUser', $this->Project->query('SELECT count(*) as total FROM (SELECT sum(funds) as funded, p.id, p.goal FROM projects AS p, transactions AS t, initiators AS i where t.project_id=p.id and i.project_id=p.id and i.user_id=' . $this->Auth->user('id') . ' GROUP BY p.id) AS funds WHERE funded >= goal;'));
    }
    
    function create() {
        $tags = $this->Project->query('SELECT * FROM macro_tags;');
        
        $cleanedTags = array();
        
        foreach($tags as $tag):
          $cleanedTags[$tag['macro_tags']['id']] = $tag['macro_tags']['name'];
        endforeach;
        
        $this->set('macroTags', $cleanedTags);
        
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

            if (strlen($this->data['Project']['other']) > 0 and strlen($this->data['Project']['other']) <= 50) {
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
                    
                        $this->Project->query('INSERT INTO project_macro_tags (macro_tag_id, project_id) VALUES (' . $this->data['Project']['category'] . ', ' . $project_id . ');');
                        if ($this->Project->query('SELECT count(*) as total FROM micro_tags WHERE name=\'' . $this->data['Project']['other'] . '\';')[0][0]['total'] == 0) {
                            $this->Project->query('INSERT INTO micro_tags (name) VALUES (\'' . $this->data['Project']['other'] . '\');');
                        }
                        $micro_tag_id = $this->Project->query('SELECT id FROM micro_tags WHERE name=\'' . $this->data['Project']['other'] . '\' LIMIT 1;')[0]['micro_tags']['id'];
                        $this->Project->query('INSERT INTO project_micro_tags (micro_tag_id, project_id) VALUES (' . $micro_tag_id . ', ' . $project_id . ');');
                        $this->Session->setFlash('Project Created.');
                        $this->redirect(array('action'=>'mine'));
                    }
                
                }
            } else {
                    $this->Session->setFlash('Other categories must be in between 1 and 50 characters');
                    $this->redirect(array('controller'=>'projects', 'action'=>'create'));
            }
        }
    }
}
