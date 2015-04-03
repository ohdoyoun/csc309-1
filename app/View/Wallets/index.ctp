<h3>Wallet</h3>

<h5>Add funds:</h5>
<?php
echo $this->Form->create('Wallet', array('action'=>'index'));
echo $this->Form->input('Amount');
echo $this->Form->end('Add');
?>
<br>

<?php 
if (sizeof($total) > 0) {?>
    <h5>Total funds remaining: <?php echo $total[0][0]['total'] ?> </h5>
<?php  
} else {?>
    <h5>Total funds remaining: 0</h5>
<?php    
}?>
<br><br>
<h5>Credits spent</h5>
<table>
    <tr>
        <th>Spent on</th>
        <th>Amount spent</th>
        <th>Towards project</th>
    </tr>
    <?php foreach($spent as $trans): ?>
    <tr>
        <td><?php echo $trans['transactions']['update_date']; ?></td>
        <td><?php echo $trans['transactions']['funds']; ?></td>
        <td><a href="./projects/view/<?php echo $trans['transactions']['project_id']; ?>"><?php echo $trans['projects']['project_name']; ?></a></td>
    </tr>
    <?php endforeach; ?>
</table>

<br><br>
<h5>Credits added</h5>
<table>
    <tr>
        <th>Added on</th>
        <th>Amount added</th>
        <th>Payment type</th>
    </tr>
    <?php foreach($wallet as $trans): ?>
    <tr>
        <td><?php echo $trans['wallet_transactions']['update_date']; ?></td>
        <td><?php echo $trans['wallet_transactions']['funds']; ?></td>
        <td><?php echo $trans['payment_methods']['description']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
