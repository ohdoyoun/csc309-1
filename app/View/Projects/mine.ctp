<h2>My Projects</h2>

<table id="my-projects">
    <tr>
        <th>Your projects you initiated</th>
    </tr>
    <?php foreach($mine as $project): ?>
    <tr>
        <td><a href="./projects/view/<?php echo $project['projects']['id']; ?>"><?php echo $project['projects']['project_name']; ?></a></td>
    </tr>
    <?php endforeach; ?>
</table>