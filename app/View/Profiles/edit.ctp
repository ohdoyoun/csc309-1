<h3>Profile of <?php echo $current_user['username']; ?></h3>

<?php 
if (!empty($users)){
    foreach($users as $user):    
        echo $this->Form->create('Profile', array('action'=>"edit"));
        echo $this->Form->input('first_name', array('default'=>$user['first_name']));
        echo $this->Form->input('last_name', array('default'=>$user['last_name']));
        echo $this->Form->input('email', array('default'=>$email));
        echo $this->Form->input('country', array('default'=>$user['country']));
        echo $this->Form->input('province', array('default'=>$user['province']));
        echo $this->Form->input('city', array('default'=>$user['city']));
        echo $this->Form->input('address', array('default'=>$user['address'], 'label'=>"Street Address"));
        echo $this->Form->input('postal_code', array('default'=>$user['postal_code']));
        echo $this->Form->input('phone_number', array('default'=>$user['phone_number']));
    
    
        echo $this->Form->input('dob', 
                                    array(
                                        'type' => 'date',
                                        'label' => 'Date of Birth:',
                                        'dateFormat' => 'MDY',
                                        'minYear' => date('Y')-130,
                                        'maxYear' => date('Y'),
                                        'options' => array('1','2'),
                                        'monthNames' => false,
                                        'selected' => date($user['dob'])
                                    )
                                );
        echo $this->Form->input('gender', array('options' => array('Male'=>'Male', 'Female'=>'Female'), 'default'=>$user['gender']));
        echo $this->Form->input('bio', array('default'=>$user['bio'], 'label'=>"Biography"));
        echo $this->Form->end('Save changes');
    endforeach;
} else {
    echo $this->Form->create('Profile', array('action'=>"edit"));
    echo $this->Form->input('first_name');
    echo $this->Form->input('last_name');
    echo $this->Form->input('email', array('default'=>$email));
    echo $this->Form->input('country');
    echo $this->Form->input('province');
    echo $this->Form->input('city');
    echo $this->Form->input('address', array('label'=>"Street Address"));
    echo $this->Form->input('postal_code');
    echo $this->Form->input('phone_number');
    echo $this->Form->input('dob', 
                                array(
                                    'type' => 'date',
                                    'label' => 'Date of Birth:',
                                    'dateFormat' => 'MDY',
                                    'minYear' => date('Y')-130,
                                    'maxYear' => date('Y'),
                                    'options' => array('1','2'),
                                    'monthNames' => false
                                )
                            );
    echo $this->Form->input('gender', array('options' => array('Male'=>'Male', 'Female'=>'Female')));
    echo $this->Form->input('bio', array('label'=>"Biography"));
    echo $this->Form->end('Create profile');
}
?>