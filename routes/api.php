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
        'only' => ['index', 'read'],
    ]);

    $api->resource('restaurants', [
        'only' => ['index', 'read'],
    ]);
});
