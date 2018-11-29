<?php

declare(strict_types=1);

namespace PhpWatch\Log\Level;

/**
 * Bootstrap.
 */
class Bootstrap extends AbstractLevel
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
            case 'danger':
                return PhpWatch::LEVEL_ERROR;
            case 'warning':
                return PhpWatch::LEVEL_WARNING;
            case 'secondary':
                return PhpWatch::LEVEL_NOTICE;
            case 'info':
                return PhpWatch::LEVEL_INFO;
            case 'success':
                return PhpWatch::LEVEL_OK;
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
                return 'danger';
            case PhpWatch::LEVEL_WARNING:
                return 'warning';
            case PhpWatch::LEVEL_NOTICE:
                return 'secondary';
            case PhpWatch::LEVEL_INFO:
                return 'info';
            case PhpWatch::LEVEL_OK:
                return 'success';
            default:
                return 'light';
        }
    }
}
