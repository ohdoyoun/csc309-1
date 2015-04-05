<h2>Backed Projects</h2>

<table>
    <tr>
        <th>Project you have backed</th>
        <th>Project goal</th>
        <th>Project end date</th>
        <th>Money raised</th>
    </tr>
    <?php foreach($backed as $project): ?>
    <tr>
        <td><a href="/projects/view/<?php echo $project['transactions']['project_id']; ?>"><?php echo $project['projects']['project_name']; ?></a></td>
        <td><?php echo $project['projects']['goal']; ?></td>
        <td><?php echo $project['projects']['end_date']; ?></td>
        <td><?php if (isset($project['0']['sum(funds)'])) { echo $project['0']['sum(funds)']; } else { echo 0;} ?></td>
    </tr>
    <?php endforeach; ?>
</table>