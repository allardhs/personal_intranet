<!DOCTYPE html>
<html><head>
	
	<?php
		
		require_once './settings.inc.php' ;
		require_once './helpers.php' ;
		
		echo showHeader( "Webcams" );
		echo showHeader_jquery();
		
	?>
	
	<style>
		html {
			background-color: #000000;
		}
		.navbar {
			background-color: #161616;
		}
	</style>
	
</head><body>
	
	<?php echo showBody_navmenu_mainpage(); ?>
	
	<section class='section'>
		<div class='container'>
			<div class='columns'>
				<div class='column'>
					<img src="http://192.168.178.161:8081/" border=0>
				</div>
				<div class='column'>
					<img src="http://192.168.178.171:8081/" border=0>
				</div>
			</div>
		</div>
	</section>
	
</body></html>
