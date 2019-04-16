<?php

use \Laravel\Lumen\Routing\Router;

/** @var Router $router */
$router->group([
    'prefix' => 'debit'
], function (Router $router) {
    $router->get('/', 'DebitController@all');
    $router->get('/{id}', 'DebitController@get');
    $router->post('/', 'DebitController@create');
    $router->put('/{id}', 'DebitController@update');
    $router->delete('/{id}', 'DebitController@delete');
});
