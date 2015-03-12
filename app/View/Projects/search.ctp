<h3>Search Project</h3>
<br>
<?php 
    echo $this->Html->div('search-project'); 
    
    echo $this->Form->create('Project', array('action'=>"search"));
    echo $this->Form->input('project_name');
    echo $this->Form->end('Search');
?>
