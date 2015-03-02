<?php 
App::uses('AppModel', 'Model');
class Initiator extends AppModel{
	
	public var $name = 'Initiator';
	
	public var $useTable = 'initiators';
	
	/*
	public function addInitiator($data){
		if(!empty($data)){
			$this->Initiator->create();
			$this->Initiator->save($data);
		}
	}*/
}
?>
