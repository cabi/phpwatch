<?php

declare(strict_types=1);

if (!\defined('APPLICATION_ROOT')) {
    \define('APPLICATION_ROOT', \dirname(__DIR__) . DIRECTORY_SEPARATOR);
}
require APPLICATION_ROOT . 'vendor/autoload.php';

$dataDir = APPLICATION_ROOT . 'data';
if (!\is_dir($dataDir)) {
    \mkdir($dataDir);
}

return \PhpWatch\Database\DatabaseManager::getInstance()
    ->getConnectionParams();
