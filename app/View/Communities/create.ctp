<h2>Create a Community</h2>

<div style="float: left; width: 500px;">
<?php
	echo $this->Form->create('Communities', array('action'=>'create'));
	echo $this->Form->input('title');
	echo $this->Form->input('category', array('type' => 'select', 'label' => 'Main category', 'options' => $macroTags));
	echo $this->Form->end('Create');
?>
</div>