<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Fund You</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
            
            <table style="width:98%">
              <tr>
                <td><div style="text-align: left;"><a href="../">Fund You</a></div></td>
                  <td><div style="text-align: center;"><a href="/accounts">Account</a> | Projects | Communities | 
                    <?php if ($logged_in): ?>
                        <?php echo $this->Html->link('Sign Out', array('controller'=>'users', 'action'=>'logout')); ?>
                    <?php else: ?>
                        <?php echo $this->Html->link('Login', array('controller'=>'users', 'action'=>'login')); ?>
                    <?php endif; ?>
                        </div></td>
                <td><div style="text-align: right;">
                <?php if ($logged_in): ?>
                    Welcome, <?php echo $current_user['username']; ?>.            
                <?php endif; ?>
            </div></td> 
              </tr>
            </table>
		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
            <?php echo $this->Session->flash('auth'); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<p>
				AwesomeCSC309
			</p>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
