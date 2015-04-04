<?php if (!empty($project)) { ?>
    <h3><?php echo $project['Project']['project_name']; ?></h3>
    
    <h5>Project initiated on: <?php echo $project['Project']['start_date']; ?></h5>
    <h5>Project ends on: <?php echo $project['Project']['end_date']; ?></h5><br>
    <h5>This projects goal is: $<?php echo $project['Project']['goal']; ?></h5>
    <h5>This project has raised: $<?php if (sizeof($current_amount) > 0) { echo $current_amount[0][0]['total']; } else { echo 0; }?></h5>
    <br>
    <h5>Project details:</h5>
    <p><?php echo $project['Project']['details']; ?></p>
    <br><br>
    <h5>Fund this project!</h5>
    <?php
        echo $this->Form->create('Project', array('action'=>'view/' . $project['Project']['id']));
        echo $this->Form->hidden('fund');
        echo $this->Form->input('Amount');
        echo $this->Form->end('Fund');
    ?>
    <?php if ($canGiveTestimony) { ?>
    <h5>Give a testimony!</h5>
    <?php
        echo $this->Form->create('Project', array('action'=>'view/' . $project['Project']['id']));
        echo $this->Form->hidden('feedback');
        echo $this->Form->input('Testimony');
        echo $this->Form->end('Submit');
    } ?>
<?php } else {?>
    <h3>No such project exists!</h3>
<?php }?>

