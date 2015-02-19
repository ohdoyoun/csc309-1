<h3>Profile of <?php echo $current_user['username']; ?></h3>

<?php 
if (!empty($users)){
    foreach($users as $user): 
        echo $this->Form->create('Account', array('action'=>"profile"));
        echo $this->Form->input('first_name', array('default'=>$user['profiles']['first_name']));
        echo $this->Form->input('last_name', array('default'=>$user['profiles']['last_name']));
        echo $this->Form->input('email', array('default'=>$email));
        echo $this->Form->input('country', array('default'=>$user['profiles']['country']));
        echo $this->Form->input('province', array('default'=>$user['profiles']['province']));
        echo $this->Form->input('city', array('default'=>$user['profiles']['city']));
        echo $this->Form->input('address', array('default'=>$user['profiles']['address'], 'label'=>"Street Address"));
        echo $this->Form->input('postal_code', array('default'=>$user['profiles']['postal_code']));
        echo $this->Form->input('phone_number', array('default'=>$user['profiles']['phone_number']));
        echo $this->Form->input('date_of_birth', 
                                    array(
                                        'type' => 'date',
                                        'label' => 'Date of Birth:<span>*</span>',
                                        'dateFormat' => 'MDY',
                                        'minYear' => date('Y')-130,
                                        'maxYear' => date('Y'),
                                        'options' => array('1','2')
                                    )
                                );
        #echo $this->Form->input('age', array('default'=>$user['profiles']['age']));
        echo $this->Form->input('gender', array('options' => array('Male'=>'Male', 'Female'=>'Female'), 'default'=>$user['profiles']['gender']));
        echo $this->Form->input('biography', array('default'=>$user['profiles']['bio']));
        echo $this->Form->end('Save changes');
    endforeach;
} else {
    echo $this->Form->create('Account', array('action'=>"profile"));
    echo $this->Form->input('first_name');
    echo $this->Form->input('last_name');
    echo $this->Form->input('email', array('default'=>$email));
    echo $this->Form->input('country');
    echo $this->Form->input('province');
    echo $this->Form->input('city');
    echo $this->Form->input('address', array('label'=>"Street Address"));
    echo $this->Form->input('postal_code');
    echo $this->Form->input('phone_number');
    echo $this->Form->input('date_of_birth', 
                                array(
                                    'type' => 'date',
                                    'label' => '<b>Date of Birth<span style="color: red;">*</span></b>',
                                    'dateFormat' => 'MDY',
                                    'minYear' => date('Y')-130,
                                    'maxYear' => date('Y'),
                                    'options' => array('1','2')
                                )
                            );
    #echo $this->Form->input('age');
    echo $this->Form->input('gender', array('options' => array('Male'=>'Male', 'Female'=>'Female')));
    echo $this->Form->input('biography');
    echo $this->Form->end('Create profile');
}
?>