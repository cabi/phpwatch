<?php

/**
 * Application Middleware.
 */
declare(strict_types=1);

namespace PhpWatch\Application;

use Adbar\SessionMiddleware;
use PhpWatch\Middleware\DatabaseMiddleware;
use PhpWatch\Middleware\InstallMiddleware;
use PhpWatch\Middleware\UserMiddleware as UserMiddleware;
use Slim\App;

/**
 * Application Middleware.
 */
class ApplicationMiddleware extends AbstractApplication
{
    /**
     * Add all middle wares.
     * From inner to outer.
     *
     * @param App   $app
     * @param array $settings
     */
    public function add(App $app): void
    {
        $app->add(new UserMiddleware($app));
        //$app->add(new SessionMiddleware($settings['session']));
        $app->add(new InstallMiddleware());
        $app->add(new DatabaseMiddleware());
    }
}
