<h2>Backed Projects</h2>


<table>
    <tr>
        <th>Project you have backed</th>
    </tr>
    <?php foreach($backed as $project): ?>
    <tr>
        <td><a href="/projects/view/<?php echo $project['transactions']['project_id']; ?>"><?php echo $project['projects']['project_name']; ?></a></td>
    </tr>
    <?php endforeach; ?>
</table>