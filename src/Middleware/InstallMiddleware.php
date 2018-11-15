<?php

/**
 * InstallMiddleware.
 */
declare(strict_types=1);

namespace PhpWatch\Middleware;

use PhpWatch\Application;
use PhpWatch\Database\DatabaseManager;
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
        if ($this->redirectInstall()) {
            return $response->withRedirect(Application::getApplication()
                ->getContainer()['router']->pathFor('install'), 302);
        }

        return $next($request, $response);
    }

    /**
     * Check if the installation have to install.
     */
    protected function redirectInstall(): bool
    {
        try {
            DatabaseManager::getQuery()
                ->select('*')
                ->from('users')
                ->setMaxResults(1)
                ->execute()
                ->fetchAll();

            return false;
        } catch (\Exception $exception) {
        }

        return false === \mb_strpos($_SERVER['REQUEST_URI'], 'install.');
    }
}
