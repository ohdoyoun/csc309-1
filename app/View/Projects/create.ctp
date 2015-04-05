<h2>Project Creation</h2>

<div style="float: left; width: 500px;">
<?php

	echo $this->Form->create('Project', array('action'=>'create'));
	echo $this->Form->input('project_name');
	echo $this->Form->input('goal');
	echo $this->Form->input('end_date');
	echo $this->Form->input('details');
	echo $this->Form->input('category', array('type' => 'select', 'label' => 'Project Category', 'options' => $macroTags));
	echo $this->Form->input('other', array('label' => 'Other Categories'));
	
	echo $this->Form->end('Create');
?>
</div>