<h2>Backed Projects</h2>


<table>
    <tr>
        <th>Project ID</th>
    </tr>
    <?php foreach($backed as $project): ?>
    <tr>
        <td><a href="projects/view/<?php echo $project['transactions']['project_id']; ?>"><?php echo $project['transactions']['project_id']; ?></a></td>
    </tr>
    <?php endforeach; ?>
</table>