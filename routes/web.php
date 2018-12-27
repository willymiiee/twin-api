<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('key', function() {
    return str_random(32);
});

$router->post('login', 'AuthController@login');
$router->post('register', 'AuthController@register');
$router->get('activate/{token}', 'AuthController@activate');

$router->group(['prefix' => 'admin', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->group(['prefix' => 'company'], function () use ($router) {
        $router->get('/', 'CompanyController@index');
        $router->put('/', 'CompanyController@update');
    });

    $router->group(['prefix' => 'location'], function () use ($router) {
        $router->get('/', 'LocationController@index');
        $router->post('/', 'LocationController@store');
        $router->get('{locationId}', 'LocationController@show');
        $router->put('{locationId}', 'LocationController@update');
        $router->delete('{locationId}', 'LocationController@destroy');
    });

    $router->group(['prefix' => 'department'], function () use ($router) {
        $router->get('/', 'DepartmentController@index');
        $router->post('/', 'DepartmentController@store');
        $router->get('{departmentId}', 'DepartmentController@show');
        $router->put('{departmentId}', 'DepartmentController@update');
        $router->delete('{departmentId}', 'DepartmentController@destroy');
    });

    $router->group(['prefix' => 'jobtitle'], function () use ($router) {
        $router->get('/', 'JobTitleController@index');
        $router->post('/', 'JobTitleController@store');
        $router->get('{jobTitleId}', 'JobTitleController@show');
        $router->put('{jobTitleId}', 'JobTitleController@update');
        $router->delete('{jobTitleId}', 'JobTitleController@destroy');
    });

    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('/', 'UserController@index');
        $router->post('/', 'UserController@store');
        $router->get('{userId}', 'UserController@show');
        $router->put('{userId}', 'UserController@update');
    });

    $router->group(['prefix' => 'store'], function () use ($router) {
        $router->get('/', 'StoreController@index');
        $router->post('/', 'StoreController@store');
        $router->get('{storeId}', 'StoreController@show');
        $router->put('{storeId}', 'StoreController@update');
        $router->delete('{storeId}', 'StoreController@destroy');
    });

    $router->group(['prefix' => 'trip'], function () use ($router) {
        $router->get('/', 'TripController@index');
        $router->post('/', 'TripController@store');

        $router->group(['prefix' => '{tripId}'], function () use ($router) {
            $router->get('/', 'TripController@show');
            $router->put('/', 'TripController@update');
            $router->delete('/', 'TripController@destroy');

            $router->group(['prefix' => 'destination'], function () use ($router) {
                $router->get('/', 'TripDestinationController@index');
                $router->get('{destinationId}', 'TripDestinationController@show');
                $router->put('{destinationId}', 'TripDestinationController@update');
            });
        });
    });
});
