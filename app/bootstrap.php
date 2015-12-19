<?php

require_once __DIR__ . '/../library/Merkury/src/Merkury/Autoloader.php';

$autoloader = new \Merkury\Autoloader(array(
    APP_PATH . '/../library/Merkury/src',
    APP_PATH . '/MerkFrameworkMVC/src'
));

spl_autoload_register(array($autoloader, 'autoload'));

require_once  __DIR__ . '/Routes.php';


\Merkury\View::setBasePath(APP_PATH . '/MerkFrameworkMVC/src/CoolBlueTest/Views');