<?php 

	$app->notFound(function() use ($app) {

		$app->render('erro/404.php');
		
	});

?>