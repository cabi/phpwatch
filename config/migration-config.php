<?php

use Doctrine\DBAL\Tools\Console\ConsoleRunner;

if(!defined('APPLICATION_ROOT'))
\define('APPLICATION_ROOT', \dirname(__DIR__) . DIRECTORY_SEPARATOR);
require APPLICATION_ROOT . 'vendor/autoload.php';

return \PhpWatch\Database\DatabaseManager::getInstance()->getConnectionParams();