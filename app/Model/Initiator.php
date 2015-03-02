<?php 
class Initiator extends AppModel{
	
	public function addInitiator($data){
		if(!empty($data)){
			$this->Initiator->create();
			$this->Initiator->save($data);
		}
	}
}
?>
