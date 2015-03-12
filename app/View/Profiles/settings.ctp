<h3>Account Settings</h3>
<br>
<?php 
    echo $this->Html->div('account-settings'); 
    
    echo $this->Form->create('Profile', array('action'=>"settings"));
    echo $this->Form->label('username', 'Currently logged in as:');
    echo $this->Form->label($current_user['username']);
    echo $this->Form->input('deleteAccount', array('value'=>true, 'type'=>'hidden'));
    echo $this->Form->end('Delete Account');
    
    echo $this->Form->create('Profile', array('action'=>"settings"));
    echo $this->Form->label('Change Password:');
    echo $this->Form->input('old_password');
    echo $this->Form->input('new_password');
    echo $this->Form->input('confirm_password');
    echo $this->Form->input('passwordChange', array('value'=>true, 'type'=>'hidden'));
    echo $this->Form->end('Change Password');
    
    echo $this->Form->create('Profile', array('action'=>"settings"));
    echo $this->Form->label('Time-Zone:');
    echo $this->Html->para(null, 'We use your Time Zone to send notification emails, for project activities and reminders.');
    echo $this->Form->label('Your Time Zone is currenty set to:');
    echo $this->Form->input('timezoneChange', array('value'=>true, 'type'=>'hidden'));
    echo $this->Form->end('Change Time Zone');
    
    echo $this->Form->create('Profile', array('action'=>"settings"));
    echo $this->Form->input('signOut', array('value'=>true, 'type'=>'hidden'));
    echo $this->Form->end('Sign Out of All Other Sessions');
    
?>
