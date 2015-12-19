<?php

define('APP_PATH' , realpath('../app'));

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once APP_PATH . '/bootstrap.php';

$app = new \Merkury\Application();

$app->run();