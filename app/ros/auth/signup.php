<?php

	use Uzu\User\UserPermission;

	$app->get('/signup', $guest(), function() use($app) {
		$app->render('auth/signup.php');
	})->name('signup');

	$app->post('/signup', $guest(), function() use($app) {
		
		$request = $app->request;

		$email = $request->post('email');
		$username = $request->post('username');
		$password = $request->post('password');
		$passwordConfirm = $request->post('password_confirm');

		$v = $app->vald;

		$v->validate([
			'email' => [$email, 'required|email|uniqueEmail'],
			'username' => [$username, 'required|alnumDash|max(20)|uniqueUser'],	
			'password' => [$password, 'required|min(6)'],
			'password_confirm' => [$passwordConfirm, 'required|matches(password)'],
		]);

		if ($v->passes()) {

			$identifier = $app->randomlib->generateString(128,7);

			$user = $app->user->create([
				'email' => $email,
				'username' => $username,
				'password' => $app->hash->password($password),
				'active' => false,
				'active_hash' => $app->hash->hash($identifier)
			]);

			$user->permissions()->create(UserPermission::$defaults);

			$app->mail->send('mail/auth/registered.php', ['user' => $user, 'identifier' => $identifier], function($message) use ($user) {
				$message->to($user->email);
				$message->subject('Thanks for registering.');
			});

			$app->flash('global', 'You have been registered!');
			return $app->response->redirect($app->urlFor('home'));
		}

		$app->render('auth/signup.php', [
			'errors' => $v->errors(),
			'request' => $request
		]);

	})->name('signup.post');

?>