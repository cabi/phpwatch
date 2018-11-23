<?php

/**
 * ApplicationRoutes.
 */
declare(strict_types=1);

namespace PhpWatch\Application;

use PhpWatch\Controller\CommandController;
use PhpWatch\Controller\ContentController;
use PhpWatch\Controller\InstallController;
use PhpWatch\Controller\LogController;
use PhpWatch\Controller\PageController;
use PhpWatch\Controller\UserController;
use Slim\App;

/**
 * ApplicationRoutes.
 */
class ApplicationRoutes extends AbstractApplication
{
    /**
     * Add the application routes.
     *
     * @param App   $app
     * @param array $settings
     */
    public function add(App $app): void
    {
        $app->get('/', ContentController::class . ':root')
            ->setName('root');

        $app->get('/home.html', ContentController::class . ':home')
            ->setName('home');

        $app->get('/about.html', ContentController::class . ':about')
            ->setName('about');

        $app->get('/page.html', PageController::class . ':list')
            ->setName('page');

        $app->map(['GET', 'POST'], '/page/create.html', PageController::class . ':create')
            ->setName('page/create');

        $app->map(['GET', 'POST'], '/install.html', InstallController::class . ':index')
            ->setName('install');

        $app->map(['GET', 'POST'], '/login.html', UserController::class . ':login')
            ->setName('login');

        $app->map(['GET'], '/logout.html', UserController::class . ':logout')
            ->setName('logout');

        $app->map(['GET'], '/log/data.json', LogController::class . ':data')
            ->setName('log/data');

        // CLI
        $app->options('/ping', CommandController::class . ':ping')
            ->setName('pingCli');
    }
}
