<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" >
    <meta http-equiv="Content-Language" content="en_US">
    <meta name="viewport" content="width=device-width">
    <meta name="google" content="notranslate">
    
    <title>Fund You</title>
    
    <?php
    	echo $this->Html->script('jquery-1.11.2.min');
		echo $this->Html->script('knockout-3.2.0');
		echo $this->Html->script('Helpers.min');
		echo $this->Html->script('PageModel.min');
		echo $this->Html->script('Navigation.min');
		echo $this->Html->script('Controller.min');
	?>
</head>
<body>
	<div class="wrapper">
		<header id="header">
			<div class="header-bar">
				<div class="settings">
					<a href="#" class="header-link" data-nav="Account">Account</a>
					<a href="#" class="header-link" data-nav="Projects">Projects</a>
					<a href="#" class="header-link" data-nav="Communities">Communities</a>
					<a href="#" data-nav="">
						<?php if ($logged_in): ?>
	                        <?php echo $this->Html->link('Sign Out', array('controller'=>'users', 'action'=>'logout')); ?>
	                    <?php else: ?>
	                        <?php echo $this->Html->link('Login', array('controller'=>'users', 'action'=>'login')); ?>
	                    <?php endif; ?>
                    </a>
				</div>
			</div>
		</header>

		<div class="site-main">
			<header> 
				<div id="page-header"></div>
			</header>
			<section id="main-body">
			</section>
		</div>
		
		<footer id="footer">
			2015 &copy; AwesomeCSC309
		</footer>
	</div>
	
	<nav id="navigation">
		<ul id="navigation-links" data-bind="foreach: navigationItems">
			<li><a href="#" data-bind="text: text"></a></li>
		</ul>
	</nav>        
</body>
	
	

<?php echo '<script>
	Controller.init({
		urls:{},
		pageModel:{}
	});
</script>'
?>
</html>

