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

        $data = [
            ['name' => 'Rob', 'age' => 40],
            ['name' => 'Rob', 'age' => 40],
            ['name' => 'Rob', 'age' => 40],
            ['name' => 'Rob', 'age' => 40],
            ['name' => 'Rob', 'age' => 40],
        ];

        $response = $response->withHeader('Cache-Control', 'must-revalidate,no-cache');

        return $response->withJson($data, 201);
    }
}
