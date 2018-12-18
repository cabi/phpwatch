<?php

/**
 * JavaScriptHandler.
 */
declare(strict_types=1);

namespace PhpWatch\Log\Level;

/**
 * JavaScriptHandler.
 */
class JavaScriptHandler extends AbstractLevel
{
    /**
     * Convert the foreignlevel to a PHP Watch level.
     *
     * @param int|string $foreignLevel
     *
     * @return int
     */
    public function toPhpWatch($foreignLevel): int
    {
        // TODO: Implement
        return 0;
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
        // TODO: Implement
        return 0;
    }
}
