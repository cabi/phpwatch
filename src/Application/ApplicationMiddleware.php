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
     * @param App $app
     */
    public function add(App $app): void
    {
        $app->add(new UserMiddleware($app));

        $sessionSettings = [
            'name' => 'slim_session',
            'lifetime' => 24,
            'path' => '/',
            'domain' => null,
            'secure' => false,
            'httponly' => true,
            'cookie_autoset' => true,
            'save_path' => null,
            'cache_limiter' => 'nocache',
            'autorefresh' => false,
            'encryption_key' => null,
            'namespace' => 'phpwatch',
        ];

        $app->add(new SessionMiddleware($sessionSettings));
        $app->add(new InstallMiddleware());
        $app->add(new DatabaseMiddleware());
    }
}
