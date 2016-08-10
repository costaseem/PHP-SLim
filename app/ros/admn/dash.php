<?php

	$app->get('/admin/dash', $admin(), function() use ($app) {

		$app->render('admn/dash.php');

	})->name('admin.dash');

?>