<?php

declare(strict_types=1);

namespace PhpWatch\Controller;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * UserController.
 */
class UserController extends AbstractController
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
    public function login(Request $request, Response $response, array $args): ResponseInterface
    {
        // Build session!!!!!

        return $this->render($request, $response, __METHOD__, []);
    }

    public function logout(Request $request, Response $response, array $args): ResponseInterface
    {
        // Drop session!!!!!

        return $response->withRedirect($this->container['router']->pathFor('login'), 307);
    }
}
