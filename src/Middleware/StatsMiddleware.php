<?php

/**
 * StatsMiddleware.
 */
declare(strict_types=1);

namespace PhpWatch\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * StatsMiddleware.
 */
class StatsMiddleware
{
    public const HEADER_MEMORY = 'X-Memory-Usage';

    public const HEADER_TIME = 'X-Response-Time';

    /**
     * Execute the middleware.
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        $server = $request->getServerParams();

        if (!isset($server['REQUEST_TIME_FLOAT'])) {
            $server['REQUEST_TIME_FLOAT'] = \microtime(true);
        }

        /** @var Response $response */
        $response = $next($request, $response);

        $time = (\microtime(true) - $server['REQUEST_TIME_FLOAT']) * 1000;

        $response = $response->withHeader(self::HEADER_TIME, \sprintf('%2.3fms', $time));

        return $response->withHeader(self::HEADER_MEMORY, $this->formatBytes(\memory_get_peak_usage(true)));
    }

    /**
     * Format bytes.
     *
     * @param int $bytes
     *
     * @return string
     */
    protected function formatBytes(int $bytes): string
    {
        $mb = $bytes / 1024 / 1024;

        return \round($mb, 2) . 'M';
    }
}
