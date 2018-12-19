<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

JsonApi::register('beta', ['namespace' => 'Api'], function ($api, $router) {
    $api->resource('categories', [
        // Only GET method (index and specific model)
        'only' => ['index', 'read'],
    ]);

    $api->resource('restaurants', [
        'only' => ['index', 'read'],
    ]);

    $api->resource('menus', [
        'only' => ['index', 'read'],
        // Only register related route (i.e. GET /menus/{ID}/restaurant)
        'has-one' => [
            'restaurant' => ['only' => 'related'],
        ],
        // Only register related route (i.e. GET /menus/{ID}/categories)
        'has-many' => [
            'categories' => ['only' => 'related'],
        ],
    ]);
});
