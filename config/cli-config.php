<?php

declare(strict_types=1);

use Doctrine\DBAL\Tools\Console\ConsoleRunner;

if (!\defined('APPLICATION_ROOT')) {
    \define('APPLICATION_ROOT', \dirname(__DIR__) . DIRECTORY_SEPARATOR);
}
require APPLICATION_ROOT . 'vendor/autoload.php';

$connection = \PhpWatch\Database\DatabaseManager::getInstance()->getConnection();

return ConsoleRunner::createHelperSet($connection);
