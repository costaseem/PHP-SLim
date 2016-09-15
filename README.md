# PHP-SLim
PHP development with Slim Framework,
Management and authentication system

This app is an implementation of the slim PHP framework with authentication baked in using best practices with twig templating in composer 
enviroment. The system uses CSRF and encryptions to make sure all the information is safe.

## Installation

The app should be handled using an Apache Server like XAMPP or WAMP for localhost.
The system is using composer as main delivery system, using composer.json:

```json
{
    "require": {
        "slim/slim": "~2.6",
        "slim/views": "0.1.*",
        "twig/twig": "~1.0",
        "phpmailer/phpmailer": "~5.2",
        "alexgarrett/violin": "2.*",
        "illuminate/database": "~5.0",
        "hassakhan/config": "0.8.*",
        "ircmaxell/random-lib": "~1.1"
    }
}
```



