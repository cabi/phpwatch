<?php

/**
 * AbstractController.
 */
declare(strict_types=1);

namespace PhpWatch\Controller;

use PhpWatch\Exception\OnlyUserException;
use PhpWatch\Exception\OnlyVisitorException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * AbstractController.
 */
abstract class AbstractController
{

    /**
     * Container.
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * View.
     *
     * @var \Slim\Views\Twig
     */
    protected $view;

    /**
     * AbstractController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->view = $this->container['view'];
    }

    /**
     * Render template.
     *
     * @param Request  $request
     * @param Response $response
     * @param string   $methodName
     * @param array    $variables
     *
     * @throws \Exception
     *
     * @return ResponseInterface
     */
    protected function render(Request $request, Response $response, string $methodName, array $variables = []): ResponseInterface
    {
        $uriPath = \parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $type = trim((string)\pathinfo($uriPath, PATHINFO_EXTENSION));
        $type = $type === '' ? 'html' : $type;
        $templateName = $this->getTemplate($methodName, $type);
        if (!\is_file(APPLICATION_ROOT . 'templates' . \DIRECTORY_SEPARATOR . $templateName) && 'html' !== $type) {
            return $response->withRedirect(\str_replace('.' . $type, '.html', $uriPath), 302);
        }

        $variables['currentUser'] = $request->getAttribute('currentUser');

        return $this->view->render($response, $templateName, $variables);
    }

    /**
     * Get the template name for the current output.
     *
     * @param string $methodName
     * @param string $type
     *
     * @throws \Exception
     *
     * @return string
     */
    protected function getTemplate(string $methodName, string $type): string
    {
        $matches = [];
        if (!\preg_match('/.*\\\\([a-zA-Z]*)Controller::(.*)/', $methodName, $matches)) {
            throw new \Exception('Invalid Controller call of methode name: ' . $methodName, 123671823);
        }

        return \ucfirst($matches[1]) . \DIRECTORY_SEPARATOR . \ucfirst($matches[2]) . '.' . $type . '.twig';
    }

    /**
     * Check user access for users only.
     *
     * @param Request $request
     *
     * @throws OnlyUserException
     */
    protected function onlyUsers(Request $request)
    {
        if (false === $request->getAttribute('currentUser')) {
            throw new OnlyUserException();
        }
    }

    /**
     * Check user access for visitors only.
     *
     * @param Request $request
     *
     * @throws OnlyVisitorException
     */
    protected function onlyVisitor(Request $request)
    {
        if (false !== $request->getAttribute('currentUser')) {
            throw new OnlyVisitorException();
        }
    }
}
