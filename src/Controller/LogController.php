<?php

/**
 * LogController.
 */

declare(strict_types=1);

namespace PhpWatch\Controller;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * LogController.
 */
class LogController extends AbstractController
{
    /**
     * Log data.
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws \Exception
     *
     * @return ResponseInterface
     */
    public function data(Request $request, Response $response, array $args): ResponseInterface
    {
        $this->onlyUsers($request);

        $data = [];

        $end = 10;
        if (isset($args['area']) && '24h' === $args['area']) {
            $end = 24;
        }

        if (isset($args['area']) && '30d' === $args['area']) {
            $end = 30;
        }

        for ($i = 1; $i <= $end; ++$i) {
            $data[] = [
                'name' => (string) $i,
                'stack' => 'Stacky' . \rand(0, 2),
                'value' => \rand(0, 100),
            ];
            $data[] = [
                'name' => (string) $i,
                'stack' => 'Stacky' . \rand(0, 2),
                'value' => \rand(0, 100),
            ];
            $data[] = [
                'name' => (string) $i,
                'stack' => 'Stacky' . \rand(0, 2),
                'value' => \rand(0, 100),
            ];
        }

        $response = $response->withHeader('Cache-Control', 'must-revalidate,no-cache');

        return $response->withJson($data, 201);
    }
}
