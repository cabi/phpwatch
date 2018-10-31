<?php

/**
 * Logger.
 */
declare(strict_types=1);

namespace PhpWatch\Container;

use Monolog\Handler\StreamHandler;
use PhpWatch\Container\Traits\InvokeContainer;

/**
 * Logger.
 */
class Logger extends \Monolog\Logger
{
    use InvokeContainer;

    /**
     * Logger constructor.
     *
     * @param string $name
     * @param array  $handlers
     * @param array  $processors
     */
    public function __construct(string $name = 'phpwatch', array $handlers = [], array $processors = [])
    {
        parent::__construct($name, $handlers, $processors);

        $fileHandler = new StreamHandler(APPLICATION_ROOT . 'logs' . \DIRECTORY_SEPARATOR . 'phpwatch.log');
        $this->pushHandler($fileHandler);
    }
}
