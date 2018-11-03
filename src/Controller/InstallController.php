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
                'username' => $params['username'],
                'password' => $params['password'],
            ];

            DatabaseManager::getQuery()->getConnection()->insert('user', $data);

            return $response->withRedirect($this->container['router']->pathFor('root'), 302);
        }

        $variables = [
        ];

        return $this->render($request, $response, __METHOD__, $variables);
    }
}
