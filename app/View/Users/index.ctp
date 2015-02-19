<h2>All Users</h2>


<table>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Password</th>
        <th>Email</th>
        <th>Role</th>
    </tr>
    <?php foreach($users as $user): ?>
    <tr>
        <td><?php echo $user['User']['id']; ?></td>
        <td><?php echo $user['User']['username']; ?></td>
        <td><?php echo $user['User']['password']; ?></td>
        <td><?php echo $user['User']['email']; ?></td>
        <td><?php echo $user['User']['role']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>