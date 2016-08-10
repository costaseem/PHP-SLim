<?php

	use Slim\Slim;
	use Slim\Views\Twig;
	use Slim\Views\TwigExtension;

	use Noodlehaus\Config;

	use RandomLib\Factory as RandomLib;

	use Uzu\User\User;
	use Uzu\Mail\Mailer;
	use Uzu\Help\Hash;
	use Uzu\Vald\Validator;

	use Uzu\Midd\BeforeMiddWare;
	use Uzu\Midd\CsrfMiddWare;
	
	session_cache_limiter(false);
	session_start();
	
	ini_set('display_errors', 'On');
	
	define('INC_ROOT', dirname(__DIR__));
	
	require '../../vendor/autoload.php';
	
	$app = new Slim([
		'mode' => file_get_contents(INC_ROOT . '/mode.php'),
		'view' => new Twig(),
		'templates.path' => INC_ROOT . '/app/vws'
	]);

	$app->add(new BeforeMiddWare);
	$app->add(new CsrfMiddWare);
	
	$app->configureMode($app->config('mode'), function() use ($app) {
		$app->config = Config::load(INC_ROOT . "/app/set/{$app->mode}.php");
	});
	
	require 'require.php';

	$app->auth = false;
	
	$app->container->set('user', function() {
		return new User;
	});

	$app->container->singleton('hash', function() use ($app) {
		return new Hash($app->config);
	});

	$app->container->singleton('vald', function() use ($app) {
		return new Validator($app->user, $app->hash, $app->auth);
	});

	$app->container->singleton('mail', function() use ($app) {
		$mailer = new PHPMailer;

		$mailer->isSMTP();
 		$mailer->Host = $app->config->get('mail.host');
 		$mailer->SMTPAuth = $app->config->get('mail.smtp_auth');
 		$mailer->SMTPSecure = $app->config->get('mail.smtp_secure');
 		$mailer->Port = $app->config->get('mail.port');
 		$mailer->Username = $app->config->get('mail.username');
 		$mailer->Password = $app->config->get('mail.password');
 		$mailer->SingleTo = true;
		$mailer->CharSet = "UTF-8";

 		$mailer->isHTML($app->config->get('mail.html'));

 		return new Mailer($app->view, $mailer);
	});

	$app->container->singleton('randomlib', function() use ($app) {
		$factory = new RandomLib;
		return $factory->getMediumStrengthGenerator();
	});

	$view = $app->view();

	$view->parserOptions = [
		'debug' => $app->config->get('twig.debug')
	];

	$view->parserExtensions = [
		new TwigExtension
	];

?>