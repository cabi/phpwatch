<?php

/**
 * UserMiddleware.
 */
declare(strict_types=1);

namespace PhpWatch\Middleware;

use PhpWatch\Application;
use PhpWatch\Database\DatabaseManager;
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

        //$userId = 1;

        try {
            throw new \Exception('Implement!!!');
            //$user = DatabaseManager::getInstance()->getConnection();
            //$request = $request->withAttribute('currentUser', $user);
        } catch (\Exception $ex) {
            $request = $request->withAttribute('currentUser', false);
        }

        try {
            $response = $next($request, $response);
        } catch (OnlyUserException $ex) {
            return $response->withRedirect(Application::getApplication()->getContainer()['router']->pathFor('user/login'), 302);
        } catch (OnlyVisitorException $ex) {
            return $response->withRedirect(Application::getApplication()->getContainer()['router']->pathFor('root'), 302);
        }

        return $response;
    }
}
