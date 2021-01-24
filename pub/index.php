<?php
declare(strict_types=1);

include_once "vendor/autoload.php";

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(dirname(__FILE__) . DIRECTORY_SEPARATOR . '.env');

define('DATABASE_DSN_PREFIX', $_ENV['DSN_PREFIX']);
define('DATABASE_HOST', $_ENV['DATABASE_HOST']);
define('DATABASE_PORT', $_ENV['DATABASE_PORT']);
define('DATABASE_NAME', $_ENV['DATABASE_NAME']);
define('DATABASE_USERNAME', $_ENV['DATABASE_USERNAME']);
define('DATABASE_PASSWORD', $_ENV['DATABASE_PASSWORD']);

var_dump('works');die;