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
     * @param App $app
     */
    abstract public function add(App $app): void;
}
