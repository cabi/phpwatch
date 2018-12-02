<?php

declare(strict_types=1);

if (!\defined('APPLICATION_ROOT')) {
    \define('APPLICATION_ROOT', \dirname(__DIR__) . DIRECTORY_SEPARATOR);
}
require APPLICATION_ROOT . 'vendor/autoload.php';

if (\is_dir(APPLICATION_ROOT . 'data')) {
    \mkdir(APPLICATION_ROOT . 'data');
}

return \PhpWatch\Database\DatabaseManager::getInstance()
    ->getConnectionParams();
