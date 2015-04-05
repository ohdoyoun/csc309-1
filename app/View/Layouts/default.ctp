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
    	echo $this->Html->css('cake.generic');
		echo $this->Html->css('account.min');
		echo $this->Html->css('footer.min');
		echo $this->Html->css('header.min');
		echo $this->Html->css('navigation.min');
		echo $this->Html->css('structure.min');
    	
    	echo $this->Html->script('jquery-1.11.2.min');
		echo $this->Html->script('knockout-3.2.0');
		echo $this->Html->script('Helpers.min');
		echo $this->Html->script('PageModel.min');
		echo $this->Html->script('Navigation.min');
		echo $this->Html->script('Controller.min');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="wrapper">
		<header id="header">
			<div class="header-bar">
				<div class="settings" data-bind="foreach: headerItems">
					<a href="#" class="header-link" data-bind="attr: { 'data-nav': nav }, text:name"></a>
				</div>
			</div>
		</header>

		<div id="is-authed" data-value="<?php echo $logged_in ?>"></div>

		<div class="site-main">
			<header> 
				<div id="page-header">
					<?php echo $this->Session->flash(); ?>
				</div>
			</header>
			<section id="main-body">
				<?php echo $this->fetch('content'); ?>
			</section>
		</div>
		
		<footer id="footer">
			2015 &copy; AwesomeCSC309
		</footer>
	</div>
	
	<nav id="navigation">
		<ul id="navigation-links" data-bind="foreach: navigationItems">
			<li><a href="#" class="nav-link" data-bind="attr: { 'data-nav': text },text: text"></a></li>
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

