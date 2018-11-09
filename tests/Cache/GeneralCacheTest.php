<?php

declare(strict_types=1);

namespace PhpWatchTest\Cache;

use PhpWatch\Cache\GeneralCache;
use PhpWatchTest\AbstractTest;

/**
 * GeneralCacheTest.
 */
final class GeneralCacheTest extends AbstractTest
{
    public function testCacheIsCalled(): void
    {
        $cache = new GeneralCache();
        $identifier = \md5((string) \time());

        $cache->cache($identifier, function () {
            return 'The value';
        });

        $this->assertEquals('The value', $cache->cache($identifier, function () {
            return 'Wrong content';
        }));
    }
}
