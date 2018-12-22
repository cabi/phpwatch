<?php

/**
 * Application Container.
 */

declare(strict_types=1);

namespace PhpWatch\Application;

use Adbar\Session;
use PhpWatch\Container\Logger;
use PhpWatch\Container\Router;
use PhpWatch\View\Twig;
use Psr\Container\ContainerInterface;
use Slim\App;

/**
 * Application Container.
 */
class ApplicationContainer extends AbstractApplication
{
    /**
     * Add the application container.
     *
     * @param App $app
     */
    public function add(App $app): void
    {
        $container = $app->getContainer();
        $container['logger'] = new Logger();

        $container['session'] = function (ContainerInterface $container) {
            return new Session('phpwatch');
        };

        $container['view'] = function (ContainerInterface $container) {
            $twig = new Twig();
            $twig->init($container);

            return $twig;
        };
    }
}
