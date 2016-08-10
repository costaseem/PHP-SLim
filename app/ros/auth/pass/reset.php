<?php

	$app->get('/pass-reset', $guest(), function() use ($app) {

		$request = $app->request;

		$email = $request->get('m');
		$identifier = $request->get('id');

		$hashedId = $app->hash->hash($identifier);

		$user = $app->user->where('email', $email)->first();

		if (!$user) {
			return $app->response->redirect($app->urlFor('home'));
		}

		if (!$user->recover_hash) {
			return $app->response->redirect($app->urlFor('home'));
		}

		if (!$app->hash->hashCheck($user->recover_hash, $hashedId)) {
			return $app->response->redirect($app->urlFor('home'));
		}

		$app->render('auth/pass/reset.php', [
			'email' => $user->email,
			'identifier' => $identifier
		]);

	})->name('pass.reset');

	$app->post('/pass-reset', $guest(), function() use ($app) {

		$request = $app->request;

		$email = $request->get('m');
		$identifier = $request->get('id');

		$password = $request->post('password');
		$passwordConfirm = $request->post('password_confirm');

		$hashedId = $app->hash->hash($identifier);

		$user = $app->user->where('email', $email)->first();

		if (!$user) {
			return $app->response->redirect($app->urlFor('home'));
		}

		if (!$user->recover_hash) {
			return $app->response->redirect($app->urlFor('home'));
		}

		if (!$app->hash->hashCheck($user->recover_hash, $hashedId)) {
			return $app->response->redirect($app->urlFor('home'));
		}

		$v = $app->vald;

		$v->validate([
			'password' => [$password, 'required|min(6)'],
			'password_confirm' => [$passwordConfirm, 'required|matches(password)']
		]);

		if ($v->passes()) {
			$user->update([
				'password' => $app->hash->password($password),
				'recover_hash' => null
			]);

			$app->flash('global', 'Your password has been reset and you can now sign in!');
			return $app->response->redirect($app->urlFor('home'));
		}

		$app->render('auth/pass/reset.php', [
			'errors' => $v->errors(),
			'email' => $user->email,
			'identifier' => $identifier
		]);

	})->name('pass.reset.post');

?>