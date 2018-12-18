<?php

/**
 * AbstractAutomatic.
 */

declare(strict_types=1);

namespace PhpWatch\Automatic;

/**
 * AbstractAutomatic.
 */
abstract class AbstractAutomatic
{
    /**
     * Get implementation name.
     *
     * @return string
     */
    abstract public function getName(): string;

    /**
     * Run the service.
     *
     * @param int $pageId
     */
    abstract public function run(int $pageId);

    /**
     * Get implementation identifier.
     *
     * @return string
     */
    public function getImplementation(): string
    {
        return \get_class($this);
    }
}
