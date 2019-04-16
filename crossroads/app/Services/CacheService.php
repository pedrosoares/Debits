<?php
/**
 * Created by PhpStorm.
 * User: pedrosoares
 * Date: 10/7/18
 * Time: 8:01 PM
 */

namespace App\Services;

/**
 * The function of this class is to storage in memory a cache
 * of anything required, in this case we use the memory Ram, you can
 * use redis, memcached or even mongodb.
 *
 * Class CacheService
 * @package App\Services
 */
class CacheService {

    private $cache = [];

    public function set(string $key, $value){
        $this->cache[$key] = $value;
    }

    public function get(string $key, $default) {
        return $this->cache[$key] ?? $default;
    }

}