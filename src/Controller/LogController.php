<?php

/**
 * LogController.
 */

declare(strict_types=1);

namespace PhpWatch\Controller;

use PhpWatch\Database\DatabaseManager;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Body;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * LogController.
 */
class LogController extends AbstractController
{
    /**
     * Log data.
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws \Exception
     *
     * @return ResponseInterface
     */
    public function data(Request $request, Response $response, array $args): ResponseInterface
    {
        $this->onlyUsers($request);

        $data = [];

        $end = 10;
        if (isset($args['area']) && '24h' === $args['area']) {
            $end = 24;
        }

        if (isset($args['area']) && '30d' === $args['area']) {
            $end = 30;
        }

        $logs = DatabaseManager::getQuery()
            ->select('*')
            ->from('logs')
            ->execute()
            ->fetchAll();

        foreach ($logs as $item) {
            $data[] = [
                'name' => \rand(0, 2),
                'stack' => $item['level'],
                'value' => \rand(0, 100), // value
            ];
        }

        for ($i = 1; $i <= $end; ++$i) {
            $data[] = [
                'name' => (string) $i,
                'stack' => 'Stacky' . \rand(0, 2),
                'value' => \rand(0, 100),
            ];
            $data[] = [
                'name' => (string) $i,
                'stack' => 'Stacky' . \rand(0, 2),
                'value' => \rand(0, 100),
            ];
            $data[] = [
                'name' => (string) $i,
                'stack' => 'Stacky' . \rand(0, 2),
                'value' => \rand(0, 100),
            ];
        }

        $response = $response->withHeader('Cache-Control', 'must-revalidate,no-cache');

        return $response->withJson($data, 201);
    }

    /**
     * Create Log data.
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
        if ($request->isPost()) {
            $params = $request->getParams();

            $data = [
                'page' => 1,
                'level' => 10,
                'source' => 'javaScript',
                'message' => $params['message'],
                // 'details' => $params['message'],
            ];
            DatabaseManager::getQuery()->getConnection()->insert('logs', $data);
        }

        // array(2) { ["value"]=> string(1) "8" ["name"]=> string(5) "ERROR" } string(67) "TypeError: stackedBar.width(...).height(...).test is not a function"

        return $response;
    }

    /**
     * Frontend handler.
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws \Exception
     *
     * @return ResponseInterface
     */
    public function frontendHandler(Request $request, Response $response, array $args): ResponseInterface
    {
        $content = \file_get_contents(APPLICATION_ROOT . 'vendor/jonnyreeves/js-logger/src/logger.min.js');

        $content .= '
Logger.useDefaults({defaultLevel: Logger.WARN});
window.addEventListener(\'error\',function(e){Logger.error(e.error.toString());}, false);
var consoleHandler = Logger.createDefaultHandler();
var phpWatchHandler = function (messages, context) {
jQuery.post(\'/index.php/log/create.html\', { message: messages[0], level: context.level });
};
Logger.setHandler(function (messages, context) {
consoleHandler(messages, context);
phpWatchHandler(messages, context);
});

        ';

        $response = $response->withHeader('Content-Type', 'text/plain;charset=utf-8');

        $response->getBody()->write($content);
        //$response = $response->withBody();
        //$response->body->write($content);

        return $response;
    }
}
