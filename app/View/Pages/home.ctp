<!DOCTYPE html>
<html>
<body>

<a href="users/register">Register</a><br>
<a href="users/index">View Users</a><br>
<a href="profiles/index">Profiles</a><br>
<?php if ($logged_in): ?>
    <a href="accounts">My Account</a>
<?php endif; ?>
</body>
</html>