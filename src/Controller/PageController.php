<?php

/**
 * PageController.
 */
declare(strict_types=1);

namespace PhpWatch\Controller;

use PhpWatch\Database\DatabaseManager;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * PageController.
 */
class PageController extends AbstractController
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
    public function list(Request $request, Response $response, array $args): ResponseInterface
    {
        $this->onlyUsers($request);

        $pages = DatabaseManager::getQuery()
            ->select('id', 'uri', 'apiKey')
            ->from('pages')
            ->execute()
            ->fetchAll();

        $variables = [
            'pages' => $pages,
        ];

        return $this->render($request, $response, __METHOD__, $variables);
    }

    /**
     * Create action.
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws \Exception
     *
     * @return ResponseInterface
     */
    public function create(Request $request, Response $response, array $args): ResponseInterface
    {
        $this->onlyUsers($request);

        if ($request->isPost()) {
            $params = $request->getParams();

            $data = [
                'uri' => $params['uri'],
                'apiKey' => $params['apiKey'],
            ];
            DatabaseManager::getQuery()->getConnection()->insert('pages', $data);

            return $response->withRedirect($this->container['router']->pathFor('page'), 302);
        }

        return $this->render($request, $response, __METHOD__, ['apiKey' => \md5((string) \microtime(true))]);
    }
}
