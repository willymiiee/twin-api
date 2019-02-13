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

$router->get('region', 'RegionController@index');

$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    $router->group(['prefix' => 'admin'], function () use ($router) {
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

        $router->group(['prefix' => 'warehouse'], function () use ($router) {
            $router->get('/', 'WarehouseController@index');
            $router->post('/', 'WarehouseController@store');
            $router->group(['prefix' => '{warehouseId}'], function () use ($router) {
                $router->get('/', 'WarehouseController@show');
                $router->put('/', 'WarehouseController@update');
                $router->delete('/', 'WarehouseController@destroy');

                $router->group(['prefix' => 'stock'], function () use ($router) {
                    $router->get('/', 'ItemStockController@index');
                    $router->post('/', 'ItemStockController@store');
                    $router->get('{stockId}', 'ItemStockController@show');
                    $router->put('{stockId}', 'ItemStockController@update');
                    $router->delete('{stockId}', 'ItemStockController@destroy');
                });
            });
        });

        $router->group(['prefix' => 'depot'], function () use ($router) {
            $router->get('/', 'DepotController@index');
            $router->post('/', 'DepotController@store');
            $router->get('{depotId}', 'DepotController@show');
            $router->put('{depotId}', 'DepotController@update');
            $router->delete('{depotId}', 'DepotController@destroy');
        });

        $router->group(['prefix' => 'team'], function () use ($router) {
            $router->get('/', 'TeamController@index');
            $router->post('/', 'TeamController@store');
            $router->get('{teamId}', 'TeamController@show');
            $router->put('{teamId}', 'TeamController@update');
            $router->delete('{teamId}', 'TeamController@destroy');
        });

        $router->group(['prefix' => 'principal'], function () use ($router) {
            $router->get('/', 'PrincipalController@index');
            $router->post('/', 'PrincipalController@store');
            $router->get('{principalId}', 'PrincipalController@show');
            $router->put('{principalId}', 'PrincipalController@update');
            $router->delete('{principalId}', 'PrincipalController@destroy');
        });

        $router->group(['prefix' => 'item'], function () use ($router) {
            $router->get('/', 'ItemController@index');
            $router->post('/', 'ItemController@store');
            $router->group(['prefix' => '{itemCode}'], function () use ($router) {
                $router->get('/', 'ItemController@show');
                $router->put('/', 'ItemController@update');
                $router->delete('/', 'ItemController@destroy');

                $router->group(['prefix' => 'price'], function () use ($router) {
                    $router->get('/', 'ItemPriceController@index');
                    $router->post('/', 'ItemPriceController@store');
                });
            });
        });
    });

    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->group(['prefix' => 'trip'], function () use ($router) {
            $router->get('active', 'ProfileController@activeTrips');
            $router->get('history', 'ProfileController@tripHistory');

            $router->group(['prefix' => '{tripId}'], function () use ($router) {
                $router->get('/', 'ProfileController@tripDetail');
                $router->put('destination/{destinationId}', 'ProfileController@updateTripDestination');
            });
        });
    });
});
