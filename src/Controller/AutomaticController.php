<?php

/**
 * AutomaticController.
 */

declare(strict_types=1);

namespace PhpWatch\Controller;

use Cron\CronExpression;
use PhpWatch\Database\DatabaseManager;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * AutomaticController.
 */
class AutomaticController extends AbstractController
{
    /**
     * List.
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

        // @todo impleemnt

        $automatics = DatabaseManager::getQuery()
            ->select('*')
            ->from('automatic')
            ->execute()
            ->fetchAll();

        // CronExpression::isValidExpression($expression);
        // CronExpression::factory($expression);

        $variables = [
            'automatics' => $automatics,
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
                'nextRun' => new \DateTime(),
                'expression' => $params['expression'],
                'lockRun' => false,
                'implementation' => $params['implementation'],
            ];
            DatabaseManager::getQuery()
                ->getConnection()
                ->insert('automatic', $data);

            return $response->withRedirect($this->container['router']->pathFor('automatic/list'), 302);
        }

        return $this->render($request, $response, __METHOD__);
    }
}
