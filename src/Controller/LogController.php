<?php

declare(strict_types=1);

namespace PhpWatch\Controller;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class LogController extends AbstractController
{
    /**
     * Home page.
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

        for ($i = 1; $i <= 24; ++$i) {
            $data[] = [
                'name' => $i,
                'value' => \rand(0, 100) / 100,
            ];
        }

        $response = $response->withHeader('Cache-Control', 'must-revalidate,no-cache');

        return $response->withJson($data, 201);
    }
}
