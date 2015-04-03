<?php
if (sizeof($user) > 0) {
    if (isset($user['User'])) { ?>
        <h2><?php echo $user['User']['username'] ?>'s profile</h2>
    <?php }
    if (sizeof($user['Profile']) > 0) { ?>
        <br>
        <h5>First name: <?php echo $user['Profile']['first_name'] ?></h5>
        <h5>Last name: <?php echo $user['Profile']['last_name'] ?></h5>
        <h5>Date of birth: <?php echo $user['Profile']['dob'] ?></h5>
        <h5>Gender: <?php echo $user['Profile']['gender'] ?></h5>
        <h5>Country: <?php echo $user['Profile']['country'] ?></h5>
        <h5>Province: <?php echo $user['Profile']['province'] ?></h5>
        <h5>City: <?php echo $user['Profile']['city'] ?></h5>
        <h5>Address: <?php echo $user['Profile']['address'] ?></h5>
        <h5>Postal code: <?php echo $user['Profile']['postal_code'] ?></h5>
        <h5>Phone number: <?php echo $user['Profile']['phone_number'] ?></h5>
        <h5>Biography: <?php echo $user['Profile']['bio'] ?></h5>
    <?php }
    if (sizeof($user['Project']) > 0) { ?>
        <br><br>
        <p><?php echo $user['User']['username'] ?>'s projects:</p>
        <table>
            <tr>
                <th>Name</th>
            </tr>
            <?php foreach($user['Project'] as $project): ?>
            <tr>
                <td><a href="/projects/view/<?php echo $project['id']; ?>"><?php echo $project['project_name']; ?></a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php }
    if (sizeof($user['User']) > 0) { ?>
        <br>
        <h5>You can contact <?php echo $user['User']['username'] ?> at <?php echo $user['User']['email'] ?></h5>
    <?php }
    
} else { ?>
<h2>No such user exists.</h2>
<?php }
?>
