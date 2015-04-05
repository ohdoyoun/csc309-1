<h2><?php echo $message; ?></h2>
</br>
<?php
if ($message != "Could not find this Community!") {
    ?>
    <table style="width: 50%;">
        <tr>
            <th>Post</th>
            <th>Username</th>
        </tr>
        <?php foreach($posts as $row): ?>
        <tr>
            <td><?php echo $row['users']['username'] ?></td>
            <td><?php echo $row['posts']['details'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h5>Posts</h5>
    <?php
        echo $this->Form->create('Posts', array('action'=>'create'));
      echo $this->Form->input('details', array('type' => 'textarea'));
      echo $this->Form->end('Create Post');
    ?>
<?php
}
?>
