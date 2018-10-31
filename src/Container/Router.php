<?php
/**
 * Router.
 */
declare(strict_types=1);

namespace PhpWatch\Container;

use PhpWatch\Container\Traits\InvokeContainer;

/**
 * Router.
 */
class Router extends \Slim\Router
{
    use InvokeContainer;

    /**
     * Relative path.
     *
     * @param string $name
     * @param array  $data
     * @param array  $queryParams
     *
     * @return string
     */
    public function relativePathFor($name, array $data = [], array $queryParams = [])
    {
        if (!isset($data['ext'])) {
            $data['ext'] = 'html';
        }
        $path = parent::relativePathFor($name, $data, $queryParams);

        if ($this->isPhpServer() && false === \mb_strpos($path, 'index.php')) {
            $path = '/index.php/' . \ltrim($path, '/');
            $this->basePath = \trim($this->basePath, '/index.php');
        }

        return $path;
    }

    /**
     * Is local PHP server is running.
     *
     * @return bool
     */
    protected function isPhpServer(): bool
    {
        return false !== \mb_strpos(\mb_strtolower($_SERVER['SERVER_SOFTWARE']), 'development server');
    }
}
