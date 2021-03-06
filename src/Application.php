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
     * Result value is for routing.
     *
     * @throws \Slim\Exception\MethodNotAllowedException
     * @throws \Slim\Exception\NotFoundException
     *
     * @return bool
     */
    public function run(): bool
    {
        if (!\defined('APPLICATION_ROOT')) {
            \define('APPLICATION_ROOT', \dirname(__DIR__) . '/');
        }

        $settings = [
            'settings' => [
                'displayErrorDetails' => true,
            ],
        ];

        self::$application = new App($settings);

        /** @var \Slim\Http\Environment $env */
        $env = self::$application->getContainer()['environment'];

        if (\preg_match('/\.(?:png|jpg|jpeg|gif|ico|css|js)$/', (string) $env->get('REQUEST_URI'))) {
            return false;
        }

        $applicationMiddleware = new ApplicationMiddleware();
        $applicationMiddleware->add(self::$application);

        $applicationContainer = new ApplicationContainer();
        $applicationContainer->add(self::$application);

        $applicationRoutes = new ApplicationRoutes();
        $applicationRoutes->add(self::$application);

        self::$application->run();

        return true;
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
