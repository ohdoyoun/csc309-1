<h2>My Projects</h2>

<table id="my-projects">
    <tr>
        <th>Projects you have initiated</th>
        <th>Project goal</th>
        <th>Project end date</th>
        <th>Money raised</th>
    </tr>
    <?php foreach($mine as $project): ?>
    <tr>
        <td><a href="/projects/view/<?php echo $project['projects']['id']; ?>"><?php echo $project['projects']['project_name']; ?></a></td>
        <td><?php echo $project['projects']['goal']; ?></td>
        <td><?php echo $project['projects']['end_date']; ?></td>
        <td><?php if (isset($project['funds']['sum(funds)'])) { echo $project['funds']['sum(funds)']; } else { echo 0;} ?></td>
    </tr>
    <?php endforeach; ?>
</table>