<?

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
        return Cache::get($key);
    }

    public function delete($key)
    {
        return Cache::forget($key);
    }

}