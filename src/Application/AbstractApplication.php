<?php

/**
 * AbstractApplication.
 */
declare(strict_types=1);

namespace PhpWatch\Application;

use Slim\App;

/**
 * AbstractApplication.
 */
abstract class AbstractApplication
{
    /**
     * Add the application logic.
     *
     * @param App   $app
     * @param array $settings
     */
    abstract public function add(App $app): void;
}
