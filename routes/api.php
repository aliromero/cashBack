<?php

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'v1'], function () {
    Route::post('first_register', 'api\v1\ApiController@FirstClientRegister');
    Route::post('login', 'api\v1\ApiController@ClientLogin');
    Route::get('shops/', 'api\v1\ApiController@getShops');
    Route::get('shop-data/{shop_id}/{customer_id?}', 'api\v1\ApiController@getProducts');
    Route::get('products/{shop_id}', 'api\v1\ApiController@getProducts');
    Route::post('addToCart/{product_id}', 'api\v1\ApiController@addCart');
    Route::get('carts/{customer_id}/{status}', 'api\v1\ApiController@carts');
    Route::get('shopsPending/{customer_id}', 'api\v1\ApiController@shopsPending');
    Route::post('saveFactor', 'api\v1\ApiController@saveFactor');
    Route::post('setFavorite', 'api\v1\ApiController@setFavorite');
    Route::get('test/{customer_id}', 'api\v1\ApiController@test');
    Route::get('shopArchive', 'api\v1\ApiController@shops');
    Route::get('shopsNear/{lat}/{lng}', 'api\v1\ApiController@shopsNear');
    Route::post('removeCart/{cart_id}', 'api\v1\ApiController@removeCart');

});

Route::group(['prefix' => 'v2'], function () {


});
