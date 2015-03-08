<h2>Project Creation</h2>

<div style="float: left; width: 500px;">
<?php

	echo $this->Form->create('Project', array('action'=>'create'));
	echo $this->Form->input('project_name');
	echo $this->Form->input('goal');
	echo $this->Form->input('end_date');
	echo $this->Form->input('details');
	echo $this->Form->end('Create');
?>
</div>