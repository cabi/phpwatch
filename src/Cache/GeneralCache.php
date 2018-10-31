<?php

/**
 * GeneralCache.
 */
declare(strict_types=1);

namespace PhpWatch\Cache;

use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;
use Phpfastcache\Core\Pool\ExtendedCacheItemPoolInterface;
use PhpWatch\Exception;

/**
 * GeneralCache.
 */
class GeneralCache
{
    /**
     * Cache instance.
     *
     * @var ExtendedCacheItemPoolInterface
     */
    protected static $cache;

    /**
     * Cache the result of the callable.
     *
     * @param string   $identifier
     * @param callable $callback
     * @param int      $lifetime
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function cache(string $identifier, callable $callback, $lifetime = 60)
    {
        try {
            if (null === self::$cache) {
                $config = new ConfigurationOption(['path' => APPLICATION_ROOT . 'var' . \DIRECTORY_SEPARATOR . 'tmp' . \DIRECTORY_SEPARATOR . 'service']);
                self::$cache = CacheManager::getInstance('files', $config);
            }
            $item = self::$cache->getItem($identifier);
            if (null === $item->get()) {
                $item->set(\call_user_func_array($callback, []))->expiresAfter($lifetime);
                self::$cache->save($item);
            }

            return $item->get();
        } catch (\Exception $ex) {
            throw new Exception('phpwatch cache problem: ' . $ex->getMessage() . ' - ' . $ex->getFile() . ':' . $ex->getLine(), 14782239);
        }
    }
}
