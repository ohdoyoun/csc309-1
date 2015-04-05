<h2>Search Results</h2>

<h3>Macro Tag</h3>
<label>Profiles</label></br>
<table style="width: 50%;">
    <tr>
        <th>Profile Name</th>
        <th>Community Name</th>
    </tr>
    <?php foreach($macro_profiles as $row): ?>
    <tr>
        <td><?php echo $row['profiles']['name']; ?></a></td>
        <td><?php echo $row['macro_tags']['name'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</br>

<label>Projects</label></br>
<table style="width: 50%;">
    <tr>
        <th>Project Name</th>
        <th>Community Name</th>
    </tr>
    <?php foreach($macro_projects as $row): ?>
    <tr>
        <td><?php echo $row['projects']['name']; ?></a></td>
        <td><?php echo $row['macro_tags']['name'] ?></td>
    </tr>
    <?php endforeach; ?>
</table></br>
</br>

<h3>Micro Tag</h3>
<label>Profiles</label></br>
<table style="width: 50%;">
    <tr>
        <th>Profile Name</th>
        <th>Sub-Community Name</th>
    </tr>
    <?php foreach($micro_profiles as $row): ?>
    <tr>
        <td><?php echo $row['profiles']['name']; ?></a></td>
        <td><?php echo $row['micro_tags']['name'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</br>

<label>Projects</label></br>
<table style="width: 50%;">
    <tr>
        <th>Project Name</th>
        <th>Sub-Community Name</th>
    </tr>
    <?php foreach($micro_projects as $row): ?>
    <tr>
        <td><?php echo $row['projects']['name']; ?></a></td>
        <td><?php echo $row['micro_tags']['name'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>