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
    
    <?php if (sizeof($testimonials) > 0) { ?>
        <br><br><h5>Testimonials from funders:</h5>
        <table>
            <tr>
                <th>User</th>
                <th>Testimony</th>
            </tr>
            <?php foreach($testimonials as $testimony): ?>
            <tr>
                <td><a href="/users/view/ <?php echo $testimony['testimonials']['user_id']; ?>"><?php echo $testimony['users']['username']; ?></a></td>
                <td><?php echo $testimony['testimonials']['testimony']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php } ?>
<?php } else {?>
    <h3>No such project exists!</h3>
<?php }?>

