<?php
declare(strict_types=1);

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
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

//$containerBuilder = new ContainerBuilder();
//$loader = new YamlFileLoader($containerBuilder, new FileLocator(CONFIG_DIR));
//$loader->load('services.yaml');

$router = new Router();
$router->registerRoute('/', \Controller\Homepage::class);
$router->registerRoute('/login', \Controller\User\LoginForm::class);
$router->registerRoute('/login', \Controller\User\LoginFormSubmit::class);
$router->registerRoute('/logout', \Controller\User\Logout::class);
$router->registerRoute('/signup', \Controller\User\Signup::class);
$router->registerRoute('/signup', \Controller\User\SignupSubmit::class);
$router->registerRoute('/swipe/add', \Controller\Swipe\Add::class);
$router->registerRoute('/author/add', \Controller\Author\Add::class);
$router->registerRoute('/author', \Controller\Author\FormSubmit::class);
$router->registerRoute('/authors', \Controller\Author\ViewList::class);
$controller = $router->getController();
$controller->execute();

