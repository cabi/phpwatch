<?php

/**
 * Php.
 */

declare(strict_types=1);

namespace PhpWatch\Log\Level;

/**
 * Php.
 */
class Php extends AbstractLevel
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
        switch ($foreignLevel) {
            case E_ERROR:
            case E_USER_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_RECOVERABLE_ERROR:
            case E_PARSE:
                return PhpWatch::LEVEL_ERROR;
            case E_WARNING:
            case E_USER_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
                return PhpWatch::LEVEL_WARNING;
            case E_USER_NOTICE:
            case E_DEPRECATED:
            case E_USER_DEPRECATED:
            case E_STRICT:
            case E_NOTICE:
                return PhpWatch::LEVEL_NOTICE;
            default:
                return PhpWatch::LEVEL_UNKNOWN;
        }
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
        switch ($phpWatchLevel) {
            case PhpWatch::LEVEL_ERROR:
                return E_USER_ERROR;
            case PhpWatch::LEVEL_WARNING:
                return E_USER_WARNING;
            case PhpWatch::LEVEL_NOTICE:
                return E_USER_NOTICE;
            default:
                return E_USER_NOTICE;
        }
    }
}
