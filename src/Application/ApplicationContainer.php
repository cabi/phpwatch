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
     * @param App   $app
     * @param array $settings
     */
    public function add(App $app): void
    {
        $container = $app->getContainer();
        $container['router'] = new Router();
        $container['logger'] = new Logger();

        $container['session'] = function (ContainerInterface $container) {
            return new Session($container->get('settings')['session']['namespace']);
        };

        $container['view'] = function (ContainerInterface $container) {
            $twig = new Twig();
            $twig->init($container);

            return $twig;
        };
    }
}
