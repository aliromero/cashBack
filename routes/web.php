<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/get_area', 'HomeController@get_area');
Route::get('shops', 'HomeController@shops');
Route::get('products/{shop?}', 'HomeController@products');
Route::get('product/{id}', 'HomeController@product');

Route::group(['prefix' => config('backpack.base.route_prefix', 'admin'), 'middleware' => ['web', 'auth']], function () {
   
    CRUD::resource('shop', 'Admin\ShopCrudController');
    CRUD::resource('city', 'Admin\CityCrudController');
    CRUD::resource('area', 'Admin\AreaCrudController');
    CRUD::resource('category', 'Admin\CategoryCrudController');
    CRUD::resource('product', 'Admin\ProductCrudController');
    CRUD::resource('banner', 'Admin\BannerCrudController');
    CRUD::resource('page', 'Admin\PageCrudController');
    CRUD::resource('vote', 'Admin\VoteCrudController');
    CRUD::resource('video', 'Admin\VideoCrudController');
    CRUD::resource('user', 'Admin\UserCrudController');
    Route::post('product/upload_images', 'Admin\ProductCrudController@ajaxUploadImages');
    Route::post('product/delete_image', 'Admin\ProductCrudController@ajaxDeleteImage');

});




