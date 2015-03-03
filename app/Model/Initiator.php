<?php 
App::uses('AppModel', 'Model');
class Initiator extends AppModel{
	
	public $name = 'Initiator';
	
	public $useTable = 'initiators';
	
	/*
	public function addInitiator($data){
		if(!empty($data)){
			$this->Initiator->create();
			$this->Initiator->save($data);
		}
	}*/
}
?>
