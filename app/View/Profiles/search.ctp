<h3>Search User</h3>
<br>
<?php
    if (empty($userSearch)) {
        echo $this->Html->div('search-user'); 
        
        echo $this->Form->create('Profile', array('action'=>"search"));
        echo $this->Form->input('username');
        echo $this->Form->end('Search');
    } else {
        echo "Found user with id:" . $userSearch;

    }
?>
