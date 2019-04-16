<?php

namespace App\Services;

/**
 * This is a service to load from the storage the registered routes,
 * in this case we use the filesystem, but if you want to use a mongodb,
 * redis, memcached fell free to implement.
 *
 * Class StorageService
 * @package App\Services
 */
class StorageService {

    public static function get(string $filename) {
        return file_get_contents(storage_path('app/'.$filename));
    }

}