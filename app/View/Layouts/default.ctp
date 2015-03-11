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
	
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<?php echo $this->fetch('content'); ?>
	
</body>
		
</html>

