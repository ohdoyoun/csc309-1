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
				<div class="settings" data-bind="foreach: headerItems">
					<a href="#" class="header-link" data-bind="attr: { 'data-nav': nav }, text:name"></a>
				</div>
			</div>
		</header>

		<div class="site-main">
			<header> 
				<div id="page-header">
					<?php echo $this->Session->flash(); ?>
				</div>
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

