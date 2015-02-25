<h2>All Profiles</h2>


<table>
    <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>First</th>
        <th>Last</th>
        <th>Date of birth</th>
        <th>Gender</th>
        <th>Country</th>
        <th>Province</th>
        <th>City</th>
        <th>Address</th>
        <th>Postal Code</th>
        <th>Phone</th>
        <th>Bio</th>
    </tr>
    <?php foreach($profiles as $profile): ?>
    <tr>
        <td><?php echo $profile['Profile']['id']; ?></td>
        <td><?php echo $profile['Profile']['user_id']; ?></td>
        <td><?php echo $profile['Profile']['first_name']; ?></td>
        <td><?php echo $profile['Profile']['last_name']; ?></td>
        <td><?php echo $profile['Profile']['dob']; ?></td>
        <td><?php echo $profile['Profile']['gender']; ?></td>
        <td><?php echo $profile['Profile']['country']; ?></td>
        <td><?php echo $profile['Profile']['province']; ?></td>
        <td><?php echo $profile['Profile']['city']; ?></td>
        <td><?php echo $profile['Profile']['address']; ?></td>
        <td><?php echo $profile['Profile']['postal_code']; ?></td>
        <td><?php echo $profile['Profile']['phone_number']; ?></td>
        <td><?php echo $profile['Profile']['bio']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>