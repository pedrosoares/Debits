<?php

namespace App\Providers;

use App\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * @var \Laravel\Lumen\Routing\Router
     */
    private $router;

    public function __construct($app) {
        parent::__construct($app);
        $this->router = $app->router;
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $routes = routes();

        foreach ($routes as $id => $route) {
            $method = strtolower($route->method);
            $middleware = "router:".($id + 1);
            $this->router->{$method}($route->uri,  [
                'uses' => 'App\Http\Controllers\GatewayController@' . $method,
                'middleware' => $middleware
            ]);
        }

        $this->app->singleton(Request::class, function () {
            return Request::capture();
        });

        $this->app->alias(Request::class, 'request');

    }
}
