<?php

	$app->get('/recover-pass', $guest(), function() use ($app) {

		$app->render('auth/pass/recover.php');

	})->name('pass.recover');

	$app->post('/recover-pass', $guest(), function() use ($app) {
		
		$request = $app->request;

		$email = $request->post('email');

		$v = $app->vald;

		$v->validate([
			'email' => [$email, 'required|email']
		]);

		if ($v->passes()) {
			$user = $app->user->where('email', $email)->first();

			if (!$user) {
				$app->flash('global', 'Could not find that user.');
				return $app->response->redirect($app->urlFor('pass.recover'));
			} else {
				$identifier = $app->randomlib->generateString(128,7);

				$user->update([
					'recover_hash' => $app->hash->hash($identifier)
				]);

				$app->mail->send('mail/auth/pass/recover.php', ['user' => $user,'identifier' => $identifier], function($message) use ($user) {
					$message->to($user->email);
					$message->subject('Recover your password.');
				});

				$app->flash('global', 'We have emailed you instructions to reset your password.');
				return $app->response->redirect($app->urlFor('home'));
			}
		}

		$app->render('auth/pass/recover.php', [
			'errors' => $v->errors(),
			'request' => $request
		]);

	})->name('pass.recover.post');

?>