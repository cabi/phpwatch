<?php

/**
 * UserMiddleware.
 */
declare(strict_types=1);

namespace PhpWatch\Middleware;

use PhpWatch\Application;
use PhpWatch\Database\DatabaseManager;
use PhpWatch\Exception;
use PhpWatch\Exception\OnlyUserException;
use PhpWatch\Exception\OnlyVisitorException;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * UserMiddleware.
 */
class UserMiddleware
{
    /**
     * Application object.
     *
     * @var App
     */
    protected $app;

    /**
     * User constructor.
     *
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Invoke middleware.
     *
     * @param Request  $request  PSR7 request
     * @param Response $response PSR7 response
     * @param callable $next     Next middleware
     *
     * @return ResponseInterface
     */
    public function __invoke(Request $request, Response $response, callable $next): ResponseInterface
    {
        /** @var \Adbar\Session $session */
        $session = $this->app->getContainer()['session'];
        $userId = (int) $session->get('userId');

        try {
            $query = DatabaseManager::getQuery();
            $user = $query
                ->select('*')
                ->from('users')
                ->where($query->expr()->eq('id', $userId))
                ->setMaxResults(1)
                ->execute()
                ->fetch();

            if (!isset($user['email'])) {
                throw new Exception('invalid user', 123789);
            }

            $request = $request->withAttribute('currentUser', $user);
        } catch (\Exception $ex) {
            $request = $request->withAttribute('currentUser', false);
        }

        try {
            $response = $next($request, $response);
        } catch (OnlyUserException $ex) {
            return $response->withRedirect(Application::getApplication()->getContainer()['router']->pathFor('login'), 302);
        } catch (OnlyVisitorException $ex) {
            return $response->withRedirect(Application::getApplication()->getContainer()['router']->pathFor('root'), 302);
        }

        return $response;
    }
}
