<h2>Search for Communities</h2>
<div style="float: left; width: 500px;">
<?php

	echo $this->Form->create('Communities', array('action'=>'create'));
	echo $this->Form->input('tag_name');
	echo $this->Form->input('category', array('type' => 'select', 'label' => 'Search Item Options', 'options' => array('Projects', 'Profiles', 'All')));
	echo $this->Form->input('category', array('type' => 'select', 'label' => 'Search Category Options', 'options' => array('Communities', 'Sub-Communities', 'All')));
	echo $this->Form->end('Search');
?>
</div>
