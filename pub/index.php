<?php
declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

define('PUB_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(PUB_DIR) . DIRECTORY_SEPARATOR);
define('SRC_DIR', implode(DIRECTORY_SEPARATOR, [ROOT_DIR, 'src', '']));
define('VAR_DIR', implode(DIRECTORY_SEPARATOR, [ROOT_DIR, 'var', '']));
define('CONFIG_DIR', implode(DIRECTORY_SEPARATOR, [VAR_DIR, 'config', '']));
define('CACHE_DIR', implode(DIRECTORY_SEPARATOR, [VAR_DIR, 'cache', '']));

include_once ROOT_DIR . "/vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load(ROOT_DIR . '.env');

define('DATABASE_DSN_PREFIX', $_ENV['DATABASE_DSN_PREFIX']);
define('DATABASE_HOST', $_ENV['DATABASE_HOST']);
define('DATABASE_PORT', $_ENV['DATABASE_PORT']);
define('DATABASE_NAME', $_ENV['DATABASE_NAME']);
define('DATABASE_USERNAME', $_ENV['DATABASE_USERNAME']);
define('DATABASE_PASSWORD', $_ENV['DATABASE_PASSWORD']);
define('APPLICATION_MODE', $_ENV['APPLICATION_MODE']);

if(APPLICATION_MODE === 'dev') {
    error_reporting(-1);
    ini_set('display_errors', 'On');
}

$router = new Router();
// user endpoints
$router->registerRoute('/', \Controller\Homepage::class);
$router->registerRoute('/login', \Controller\User\LoginForm::class);
$router->registerRoute('/login', \Controller\User\LoginFormSubmit::class);
$router->registerRoute('/logout', \Controller\User\Logout::class);
$router->registerRoute('/signup', \Controller\User\Signup::class);
$router->registerRoute('/signup', \Controller\User\SignupSubmit::class);
// author endpoints
$router->registerCRUDRoutes(\Model\Author::ENTITY, 'Controller\Author');
// swipe endpoints
$router->registerCRUDRoutes(\Model\Swipe::ENTITY, 'Controller\Swipe');
$router->registerRoute('/swipe/comment/create', \Controller\SwipeComment\REST\Create::class);
$router->registerRoute('/swipe/comment/delete', \Controller\SwipeComment\REST\Delete::class);

$controller = $router->getController();
$controller->execute();

