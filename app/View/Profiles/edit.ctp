<h3>Your profile</h3>

<?php 
if (!empty($users)){  
    echo $this->Form->create('Profile', array('action'=>"edit"));
    echo $this->Form->input('first_name', array('default'=>$users['first_name']));
    echo $this->Form->input('last_name', array('default'=>$users['last_name']));
    echo $this->Form->input('email', array('default'=>$email));
    echo $this->Form->input('country', array('default'=>$users['country']));
    echo $this->Form->input('province', array('default'=>$users['province']));
    echo $this->Form->input('city', array('default'=>$users['city']));
    echo $this->Form->input('address', array('default'=>$users['address'], 'label'=>"Street Address"));
    echo $this->Form->input('postal_code', array('default'=>$users['postal_code']));
    echo $this->Form->input('phone_number', array('default'=>$users['phone_number']));


    echo $this->Form->input('dob', 
                                array(
                                    'type' => 'date',
                                    'label' => 'Date of Birth:',
                                    'dateFormat' => 'MDY',
                                    'minYear' => date('Y')-130,
                                    'maxYear' => date('Y'),
                                    'options' => array('1','2'),
                                    'monthNames' => false,
                                    'selected' => date($users['dob'])
                                )
                            );
    echo $this->Form->input('gender', array('options' => array('Male'=>'Male', 'Female'=>'Female'), 'default'=>$users['gender']));
    echo $this->Form->input('bio', array('default'=>$users['bio'], 'label'=>"Biography"));
    echo $this->Form->input('category', array('type' => 'select', 'label' => 'Main Interest', 'options' => $macroTags, 'selected' => $macroTag[0]['profile_macro_tags']['macro_tag_id']));
	echo $this->Form->input('other', array('label' => 'Other Interests', 'default' => $microTag[0]['micro_tags']['name']));
    echo $this->Form->end('Save changes');
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
    echo $this->Form->input('category', array('type' => 'select', 'label' => 'Main Interest', 'options' => $macroTags));
	echo $this->Form->input('other', array('label' => 'Other Interests'));
    echo $this->Form->end('Create profile');
}
?>