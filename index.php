<?php
declare(strict_types=1);

include_once "vendor/autoload.php";

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(dirname(__FILE__) . DIRECTORY_SEPARATOR . '.env');

