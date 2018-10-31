<?php

/**
 * Application.
 */
declare(strict_types=1);

namespace PhpWatch;

use PhpWatch\Application\ApplicationContainer;
use PhpWatch\Application\ApplicationMiddleware;
use PhpWatch\Application\ApplicationRoutes;
use Slim\App;

/**
 * Application.
 */
class Application
{
    /**
     * Application.
     *
     * @var App
     */
    protected static $application = null;

    /**
     * Run the application.
     */
    public function run(): void
    {
        if (!\defined('APPLICATION_ROOT')) {
            \define('APPLICATION_ROOT', \dirname(__DIR__) . '/');
        }

        self::$application = new App();

        $applicationMiddleware = new ApplicationMiddleware();
        $applicationMiddleware->add(self::$application);

        $applicationContainer = new ApplicationContainer();
        $applicationContainer->add(self::$application);

        $applicationRoutes = new ApplicationRoutes();
        $applicationRoutes->add(self::$application);

        self::$application->run();
    }

    /**
     * Get the current application instance.
     *
     * @return App
     */
    public static function getApplication(): App
    {
        return self::$application;
    }
}
