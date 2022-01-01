<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Dingo\Api\Routing\Router;
use Illuminate\Support\Facades\Route;

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

/** @var Router $api */
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function (Router $api) {
    $api->post('login', ['as' => 'login', 'uses' => 'App\Http\Controllers\LoginController']);
    $api->post('signup', ['as' => 'signup', 'uses' => 'App\Http\Controllers\SignupController']);
});

$api->version('v1', ['middleware' => 'api.auth'], function (Router $api) {
    $api->resource('users', UserController::class);
});
