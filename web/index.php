<?php
$base = __DIR__ . '/../';
$loader = false;
foreach ([$base . 'autoload.php',
             $base . 'vendor/autoload.php',
             $base . '../autoload.php',
             $base . '../../autoload.php'] as $file) {
    if (is_file($file)) {
        $loader = include($file);
        break;
    }
}

$loader or die('Composer not found. Do you run `composer install`?');
(new \PhpWatch\Application())->run();