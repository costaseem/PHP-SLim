<?php

	$app->get('/signout', function() use ($app) {

		unset($_SESSION[$app->config->get('auth.session')]);

		if ($app->getCookie($app->config->get('auth.remember'))) {
			$app->auth->removeRememberCredentials();
			$app->deleteCookie($app->config->get('auth.remember'));
		}

		$app->flash('global', 'You have been signed out!');
		return $app->response->redirect($app->urlFor('home'));

	})->name('signout');

?>