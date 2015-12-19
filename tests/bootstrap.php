<?php

define('APP_PATH' , realpath('../app'));

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../library/Merkury/src/Merkury/Autoloader.php';

$autoloader = new \Merkury\Autoloader(array(
    APP_PATH . '/../library/Merkury/src'
));

//global $autoloader;

spl_autoload_register(array($autoloader, 'autoload'));