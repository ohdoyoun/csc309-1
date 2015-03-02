<h2>Project</h2>

<?php if (!empty($project)) { ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Goal</th>
            <th>Start</th>
            <th>End</th>
            <th>Status</th>
            <th>Details</th>
        </tr>
        <tr>
            <td><?php echo $project['Project']['id']; ?></td>
            <td><?php echo $project['Project']['project_name']; ?></td>
            <td><?php echo $project['Project']['goal']; ?></td>
            <td><?php echo $project['Project']['start_date']; ?></td>
            <td><?php echo $project['Project']['end_date']; ?></td>
            <td><?php echo $project['Project']['status_tag_id']; ?></td>
            <td><?php echo $project['Project']['details']; ?></td>
        </tr>
    </table>
<?php } else {?>
    <h1>No such project exists!</h1>
<?php }?>