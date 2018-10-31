<?php

/**
 * ContentController.
 */
declare(strict_types=1);

namespace PhpWatch\Controller;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * ContentController.
 */
class CommandController extends AbstractController
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
    public function ping(Request $request, Response $response, array $args): ResponseInterface
    {
        return $this->render($request, $response, __METHOD__);
    }
}
