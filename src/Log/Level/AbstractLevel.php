<?php

declare(strict_types=1);

namespace PhpWatch\Log\Level;

abstract class AbstractLevel
{
    /**
     * Convert the foreignlevel to a PHP Watch level.
     *
     * @param int|string $foreignLevel
     *
     * @return int
     */
    abstract public function toPhpWatch($foreignLevel): int;

    /**
     * Convert the PHP Watch level to the current level.
     *
     * @param int $phpWatchLevel
     *
     * @return int|string
     */
    abstract public function fromPhpWatch(int $phpWatchLevel);
}
