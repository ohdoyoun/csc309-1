<h2>All Projects</h2>


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
    <?php foreach($projects as $project): ?>
    <tr>
        <td><?php echo $project['Project']['id']; ?></td>
        <td><?php echo $project['Project']['project_name']; ?></td>
        <td><?php echo $project['Project']['goal']; ?></td>
        <td><?php echo $project['Project']['start_date']; ?></td>
        <td><?php echo $project['Project']['end_date']; ?></td>
        <td><?php echo $project['Project']['status_tag_id']; ?></td>
        <td><?php echo $project['Project']['details']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>