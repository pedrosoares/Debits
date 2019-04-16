<?php

namespace App\Services;


use App\Endpoint;

/**
 * This Service is used to load the routes
 * and control the cache
 *
 * Class GatewayService
 * @package App\Services
 */
class GatewayService {

    /**
     * @var CacheService
     */
    private static $cache = null;

    /**
     * Return all Endpoints(routes) or if the id is passed
     * return only one, the (ID - 1) because the router system
     * does not accept 0 as parameter (Workaround, sorry).
     *
     * @param int|null $id
     * @return CacheService|mixed
     */
    public static function getRoutes(int $id = null){
        $config = app("config");
        $useCache = $config["gateway"]["use_router_cache"];
        $cached = $useCache && isset(GatewayService::$cache);

        if($cached){
            $endpoints = GatewayService::$cache->get("endpoints", "");
            if(isset($id) && is_numeric($id)){
                return $endpoints[$id - 1];
            }
            return $endpoints;
        }

        if($useCache) {
            GatewayService::$cache = app($config["gateway"]["router_cache_driver"]);
        }

        $cache = Endpoint::parse(StorageService::get("router.json"));

        if($useCache) GatewayService::$cache->set("endpoints", $cache);

        if(isset($id) && is_numeric($id)){
            return $cache[$id - 1];
        }
        return $cache;
    }

    /**
     * Find Route By URI
     *
     * @param string $uri
     * @return Endpoint|null
     */
    public static function findRoute(string $uri){
        $routes = GatewayService::getRoutes();
        return array_first($routes, function (Endpoint $endpoint) use($uri) {
            return $endpoint->uri == $uri;
        });
    }

}