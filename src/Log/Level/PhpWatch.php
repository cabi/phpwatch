<?php

/**
 * PhpWatch.
 */

declare(strict_types=1);

namespace PhpWatch\Log\Level;

/**
 * PhpWatch.
 */
class PhpWatch extends AbstractLevel
{
    const LEVEL_ERROR = 50;

    const LEVEL_WARNING = 40;

    const LEVEL_NOTICE = 30;

    const LEVEL_INFO = 20;

    const LEVEL_OK = 10;

    const LEVEL_UNKNOWN = 0;

    /**
     * Convert the foreignlevel to a PHP Watch level.
     *
     * @param int|string $foreignLevel
     *
     * @return int
     */
    public function toPhpWatch($foreignLevel): int
    {
        return (int) $foreignLevel;
    }

    /**
     * Convert the PHP Watch level to the current level.
     *
     * @param int $phpWatchLevel
     *
     * @return int|string
     */
    public function fromPhpWatch(int $phpWatchLevel)
    {
        return $phpWatchLevel;
    }
}
