<h2>My Projects</h2>


<table>
    <tr>
        <th>Initiator</th>
        <th>Project ID</th>
    </tr>
    <?php foreach($mine as $project): ?>
    <tr>
        <td><?php echo $project['Initiator']['user_id']; ?></td>
        <td><?php echo $project['Initiator']['project_id']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>