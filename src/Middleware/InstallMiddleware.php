<?php

/**
 * InstallMiddleware.
 */
declare(strict_types=1);

namespace PhpWatch\Middleware;

use PhpWatch\Application;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * InstallMiddleware.
 */
class InstallMiddleware
{
    /**
     * Invoke middleware.
     *
     * @param Request  $request  PSR7 request
     * @param Response $response PSR7 response
     * @param callable $next     Next middleware
     *
     * @return ResponseInterface
     */
    public function __invoke(Request $request, Response $response, callable $next): ResponseInterface
    {
        if ($this->haveToInstall()) {
            //return $response->withRedirect(Application::getApplication()
            //                                   ->getContainer()['router']->pathFor('install'), 302);
        }

        return $next($request, $response);
    }

    /**
     * Check if the installation have to install.
     */
    protected function haveToInstall(): bool
    {
        return true;
    }
}
