<h2>Backed Projects</h2>


<table>
    <tr>
        <th>Project ID</th>
    </tr>
    <?php foreach($backed as $project): ?>
    <tr>
        <td><?php echo $project['transactions']['project_id']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>