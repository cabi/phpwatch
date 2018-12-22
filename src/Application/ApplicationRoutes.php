<?php

/**
 * ApplicationRoutes.
 */

declare(strict_types=1);

namespace PhpWatch\Application;

use PhpWatch\Controller\AutomaticController;
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
     * @param App $app
     */
    public function add(App $app): void
    {
        $app->get('/', ContentController::class . ':root')
            ->setName('root');

        $app->get('/home', ContentController::class . ':home')
            ->setName('home');

        $app->get('/about', ContentController::class . ':about')
            ->setName('about');

        $app->group('/page', function () use ($app) {
            // @todo Handle CRUD via WEB and Service
            // List
            $app->get('', PageController::class . ':list')
                ->setName('page/list');

            $app->map(['GET', 'POST', 'PUT'], '/create', PageController::class . ':create')
                ->setName('page/create');

            // Delete
            $app->map(['GET', 'DELETE'], '/{id}', PageController::class . ':delete')
                ->setName('page/delete');
        });
        $app->group('/automatic', function () use ($app) {
            // @todo Handle CRUD via WEB and Service
            // List
            $app->get('', AutomaticController::class . ':list')
                ->setName('automatic/list');

            $app->get('cron', AutomaticController::class . ':cron')
                ->setName('automatic/cron');

            $app->map(['GET', 'POST', 'PUT'], '/create', AutomaticController::class . ':create')
                ->setName('automatic/create');

            // Delete
            $app->map(['GET', 'DELETE'], '/{id}', AutomaticController::class . ':delete')
                ->setName('automatic/delete');
        });

        $app->map(['GET', 'POST'], '/install', InstallController::class . ':index')
            ->setName('install');

        $app->map(['GET', 'POST'], '/login', UserController::class . ':login')
            ->setName('login');

        $app->map(['GET'], '/logout', UserController::class . ':logout')
            ->setName('logout');

        $app->group('/log', function () use ($app) {
            // @todo Handle CRUD via WEB and Service
            // List
            $app->get('', PageController::class . ':list')
                ->setName('page/list');

            $app->map(['GET'], '/data[/{area}]', LogController::class . ':data')
                ->setName('log/data');

            $app->map(['GET', 'POST', 'PUT'], '/create', LogController::class . ':create')
                ->setName('log/create');
        });

        $app->get('/log/frontendHandler.js', LogController::class . ':frontendHandler')
            ->setName('log/frontendHandler');

        // CLI
        $app->options('/ping', CommandController::class . ':ping')
            ->setName('pingCli');
    }
}
