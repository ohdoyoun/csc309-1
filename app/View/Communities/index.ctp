<h2>All Communities</h2>

<?php
debug($communities);
?>

<table>
    <tr>
        <th>Communities</th>
    </tr>
    <?php foreach($communities as $community): ?>
    <tr>
        <td><?php echo $community['User']['id']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>