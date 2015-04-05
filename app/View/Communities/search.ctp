<h2>Search for Communities</h2>
<div style="float: left; width: 500px;">
<?php

	echo $this->Form->create('Communities', array('action'=>'search'));
	echo $this->Form->input('tag_name');
	echo $this->Form->input('category', array(
		'type' => 'select', 
		'label' => 'Search Item Options', 
		'options' => array(
			'Profiles', 
			'Projects', 
			'All'
		),
		'selected' => 'All'
		)
	);
	echo $this->Form->input('community', array(
		'type' => 'select', 
		'label' => 'Search Category Options', 
		'options' => array(
			'Communities', 
			'Sub-Communities', 
			'All'
		),
		'selected' => 'All'
		)
	);
	echo $this->Form->end('Search');
?>
</div>
