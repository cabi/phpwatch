<?php

/**
 * InstallController.
 */
declare(strict_types=1);

namespace PhpWatch\Controller;

use PhpWatch\Database\DatabaseManager;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * InstallController.
 */
class InstallController extends AbstractController
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
    public function index(Request $request, Response $response, array $args): ResponseInterface
    {
        if ($request->isPost()) {
            $params = $request->getParams();

            $data = [
                'email' => $params['email'],
                'password' => \md5($params['password']),
            ];

            DatabaseManager::getQuery()->getConnection()->insert('users', $data);

            return $response->withRedirect($this->container['router']->pathFor('root'), 302);
        }

        return $this->render($request, $response, __METHOD__, []);
    }
}
