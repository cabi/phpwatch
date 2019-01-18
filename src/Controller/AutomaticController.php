<?php

/**
 * AutomaticController.
 */

declare(strict_types=1);

namespace PhpWatch\Controller;

use Cron\CronExpression;
use PhpWatch\Automatic\StaticMetaFiles;
use PhpWatch\Automatic\WeekReport;
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

        $automatics = DatabaseManager::getQuery()
            ->select('*')
            ->from('automatics')
            ->execute()
            ->fetchAll();

        $variables = [
            'automatics' => $automatics,
            'implementations' => $this->getImplementations(),
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
                'nextRun' => (new \DateTime())->format(\DateTime::ISO8601),
                'expression' => $params['expression'],
                'lockRun' => false,
                'implementation' => $params['implementation'],
                'page' => $params['page'],
            ];

            // @todo Validate
            // CronExpression::isValidExpression($expression);
            // CronExpression::factory($expression);

            DatabaseManager::getQuery()
                ->getConnection()
                ->insert('automatics', $data);

            return $response->withRedirect($this->container['router']->pathFor('automatic/list'), 302);
        }
        $variables = [
            'implementations' => $this->getImplementations(),
            'pages' => DatabaseManager::getQuery()
                ->select('*')
                ->from('pages')
                ->execute()
                ->fetchAll(),
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
    public function cron(Request $request, Response $response, array $args): ResponseInterface
    {
        $this->onlyUsers($request);

        $needRun = DatabaseManager::getQuery()
            ->select('*')
            ->from('automatics')
            ->where('nextRun <= ? AND lockRun = ?')
            ->setParameter(0, (new \DateTime())->format(\DateTime::ISO8601))
            ->setParameter(1, false)
            ->execute()
            ->fetchAll();

        foreach ($needRun as $item) {
            $implementation = new $item['implementation']();

            $implementation->run((int) $item['page']);

            $result = CronExpression::factory($item['expression']);
            $next = $result->getNextRunDate();

            DatabaseManager::getQuery()
                ->getConnection()
                ->update('automatics', ['nextRun' => $next->format(\DateTime::ISO8601)], ['id' => $item['id']]);
        }

        return $response->withRedirect($this->container['router']->pathFor('automatic/list'), 302);
    }

    /**
     * @return array
     */
    protected function getImplementations(): array
    {
        return [
            new StaticMetaFiles(),
            new WeekReport(),
        ];
    }
}
