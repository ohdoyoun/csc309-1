<h3>Notifications</h3>
<br>

<h5>Projects You Back</h5>
<?php
    echo $this->Form->create('Profile', array('action'=>"notifications"));

    echo $this->Form->input('newCommentsBacked', array(
        'type' => 'checkbox',
        'label' => 'New Comments'
    ));
    echo $this->Form->input('newProjectUpdates', array(
        'type' => 'checkbox',
        'label' => 'New Project Updates'
    ));
?>
<br><br>

<h5>Projects You Started</h5>
<?php
    echo $this->Form->input('newPledges', array(
        'type' => 'checkbox',
        'label' => 'New Pledges'
    ));
    echo $this->Form->input('newCommentsYours', array(
        'type' => 'checkbox',
        'label' => 'New Comments'
    ));
?>
<br><br>

<h5>Communities</h5>
<?php
    echo $this->Form->input('newCommunities', array(
        'type' => 'checkbox',
        'label' => 'New Interesting Projects in your communities'
    ));
    echo $this->Form->end('Save all changes');
?>