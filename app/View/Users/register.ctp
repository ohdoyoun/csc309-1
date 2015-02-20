<h2>Register</h2>
<?php
echo $this->Form->create('User', array('action'=>'register'));
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->input('password_confirmation', array('type'=>'password'));
echo $this->Form->input('email');
echo $this->Form->input('role', array(
    'options' => array('Backer'=>'Backer', 'Initiator'=>'Initiator')));
echo $this->Form->end('Register');

?>