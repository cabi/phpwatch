<?php

declare(strict_types=1);

namespace PhpWatchTest;

use PHPUnit\Framework\TestCase;

abstract class AbstractTest extends TestCase
{
    /**
     * AbstractTest constructor.
     *
     * @param string|null $name
     * @param array       $data
     * @param string      $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        if (!\defined('APPLICATION_ROOT')) {
            \define('APPLICATION_ROOT', \dirname(__DIR__) . '/');
        }
        parent::__construct($name, $data, $dataName);
    }
}
