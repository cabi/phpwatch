<?php

/**
 * DatabaseMiddleware.
 */
declare(strict_types=1);

namespace PhpWatch\Middleware;

use PhpWatch\Database\DatabaseManager;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * DatabaseMiddleware.
 */
class DatabaseMiddleware
{
    public const HEADER_DB = 'X-Database-Queries';

    /**
     * Invoke middleware.
     *
     * @param Request  $request  PSR7 request
     * @param Response $response PSR7 response
     * @param callable $next     Next middleware
     *
     * @throws \Doctrine\DBAL\DBALException
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        DatabaseManager::getInstance()->getConnection()->connect();
        $response = $next($request, $response);

        return $response;
    }
}
