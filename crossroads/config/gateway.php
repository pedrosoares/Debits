<?php

return [

    /*
    | This if false will copy the microservice
    | header and return to the user, if false only
    | the Content-Type will be copied.
    */
    "override_header" => env('OVERRIDE_HEADER', true),

    /*
    | If the Microservice not return a Content-Type header
    | this will be used.
    */
    "default_content_type" => env('DEFAULT_CONTENT_TYPE', "text/html; charset=UTF-8"),

    /*
    | If this is set to true cache is used to store the routes
    | into the driver
    */
    "use_router_cache" => true,

    /*
    | This is the driver responsible to store
    | the route array.
    | All drivers should derive from \App\Services\CacheService.
    */
    "router_cache_driver" => \App\Services\CacheService::class,

    /*
    | Authorization end point.
    | This endpoint is used to validate if the request is allowed to
    | be performed by the user permission system.
    */
    "permission_endpoint" => env('PERMISSION_ENDPOINT', "/auth/can"),

];