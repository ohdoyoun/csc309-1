<?php 
App::uses('AppModel', 'Model');
class Initiator extends AppModel{
	
	// The name of the Model.
	public $name = 'Initiator';
	
	// The table that is linked with his Model.
	public $useTable = 'initiators';
	
	/*
	Add function for this table. 
	Note - No longer needed sine there is a global add function.
	public function addInitiator($data){
		if(!empty($data)){
			$this->Initiator->create();
			$this->Initiator->save($data);
		}
	}*/
}
?>
