<?php

	$app->get('/change-pass', $authenticated(), function() use ($app) {

		$app->render('auth/pass/change.php');

	})->name('pass.change');

	$app->post('/change-pass', $authenticated(), function() use ($app) {

		$request = $app->request;

		$passwordOld = $app->request->post('password_old');
		$password = $app->request->post('password');
		$passwordConfirm = $app->request->post('password_confirm');

		$v = $app->vald;

		$v->validate([
			'password_old' => [$passwordOld, 'required|matchesCurrentPass'],
			'password' => [$password, 'required|min(6)'],
			'password_confirm' => [$passwordConfirm, 'required|matches(password)']
		]);

		if ($v->passes()) {

			$user = $app->auth;
			
			$user->update([
				'password' => $app->hash->password($password)
			]);

			$app->mail->send('mail/auth/pass/change.php', [], function($message) use ($user) {
				$message->to($user->email);
				$message->subject('You changed your password!');
			});

			$app->flash('global', 'You changed your password.');
			return $app->response->redirect($app->urlFor('home'));

		}

		$app->render('auth/pass/change.php', [
			'errors' => $v->errors()
		]);

	})->name('pass.change.post');

?>