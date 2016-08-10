<?php

$app->get('/acc/profile', $authenticated(), function() use ($app) {

	$app->render('accs/profile.php');

})->name('acc.profile');

$app->post('/acc/profile', $authenticated(), function() use ($app) {

	$request = $app->request;

	$email = $request->post('email');
	$firstName = $request->post('first_name');
	$lastName = $request->post('last_name');

	$v = $app->vald;

	$v->validate([
		'email' => [$email, 'required|email|uniqueEmail'],
		'first_name' => [$firstName, 'alpha|max(50)'],
		'last_name' => [$lastName, 'alpha|max(50)']
	]);

	if ($v->passes()) {
		$app->auth->update([
			'email' => $email,
			'first_name' => $firstName,
			'last_name' => $lastName
		]);

		$app->flash('global', 'Your details have been updated!');
		return $app->response->redirect($app->urlFor('acc.profile'));
	}

	$app->render('accs/profile.php', [
		'errors' => $v->errors(),
		'request' => $request
	]);

})->name('acc.profile.post');

?>