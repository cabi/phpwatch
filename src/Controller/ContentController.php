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
class ContentController extends AbstractController
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
    public function home(Request $request, Response $response, array $args): ResponseInterface
    {
        $this->onlyUsers($request);

        return $this->render($request, $response, __METHOD__);
    }

    /**
     * About page.
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws \Exception
     *
     * @return ResponseInterface
     */
    public function about(Request $request, Response $response, array $args): ResponseInterface
    {
        $this->onlyUsers($request);

        return $this->render($request, $response, __METHOD__);
    }

    /**
     * Root page (just redirect to the home page).
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws \PhpWatch\Exception\OnlyUserException
     *
     * @return ResponseInterface
     */
    public function root(Request $request, Response $response, array $args): ResponseInterface
    {
        $this->onlyUsers($request);

        return $response->withHeader('Location', $this->container['router']->pathFor('home'));
    }
}
