<?php

/**
 * Trait InvokeContainer.
 */
declare(strict_types=1);

namespace PhpWatch\Container\Traits;

/**
 * Trait InvokeContainer.
 */
trait InvokeContainer
{
    /**
     * Return self.
     *
     * @return self
     */
    public function __invoke()
    {
        return $this;
    }
}
