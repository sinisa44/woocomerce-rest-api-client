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


$router->group(['prefix' => 'api'], function () use ( $router ){
    //PRODUCTS
    $router->post( 'store', 'ProductController@store' );
    $router->get( '/products', 'ProductController@index' );
    $router->get( '/products/{id}', 'ProductController@show' );
    $router->get( '/categories', 'ApiController@categories' );

    //CUSTOMERS
    $router->post( 'customers' , 'CustomerController@store' );
    $router->get( '/customers', 'CustomerController@index' );
    $router->get( '/customer/{id}', 'CustomerController@show' );
});
