<?php

declare(strict_types=1);

namespace PhpWatch\Controller;

use Adbar\Session;
use PhpWatch\Application;
use PhpWatch\Database\DatabaseManager;
use PhpWatch\Exception\OnlyUserException;
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
        $this->onlyVisitor($request);

        if ($request->isPost()) {
            $params = $request->getParams();

            $data = [
                'email' => $params['email'],
                'password' => $params['password'],
            ];

            $query = DatabaseManager::getQuery();

            $user = $query
                ->select('*')
                ->from('users')
                ->where($query->expr()->eq('email', $query->expr()->literal($params['email'])))
                ->setMaxResults(1)
                ->execute()
                ->fetch();

            if (isset($user['email']) && $user['password'] === \md5($params['password'])) {
                /** @var Session $session */
                $session = Application::getApplication()->getContainer()['session'];
                $session->set('userId', (int) $user['id']);
            }

            return $response->withRedirect($this->container['router']->pathFor('login'), 302);
        }

        return $this->render($request, $response, __METHOD__, []);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws OnlyUserException
     *
     * @return ResponseInterface
     */
    public function logout(Request $request, Response $response, array $args): ResponseInterface
    {
        $this->onlyUsers($request);

        /** @var Session $session */
        $session = Application::getApplication()->getContainer()['session'];
        $session->delete('userId');

        return $response->withRedirect($this->container['router']->pathFor('login'), 307);
    }
}
