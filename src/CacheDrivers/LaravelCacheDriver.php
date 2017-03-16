<?php

namespace DivineOmega\ThisIsHowIRole\CacheDrivers;

use DivineOmega\ThisIsHowIRole\Interfaces\CacheDriverInterface;
use Illuminate\Support\Facades\Cache;

class LaravelCacheDriver implements CacheDriverInterface {

    public function set($key, $value)
    {
        return Cache::put($key, $value, 60 * 24);
    }

    public function get($key)
    {
        $cachedItem = Cache::get($key);
        
        // Laravel's caching return null if item is not found in the cache.
        // We are standardising this to return false, preventing issues with
        // objects that have no roles associated to them.
        if ($cachedItem===null) {
            return false;
        }

        return $cachedItem;
    }

    public function delete($key)
    {
        return Cache::forget($key);
    }

}