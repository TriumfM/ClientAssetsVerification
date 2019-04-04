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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/auth/login', 'AuthController@login');
// Users Routes
Route::get('/users', 'UserController@index');
Route::get('/users/{id}',  'UserController@show');
Route::post('/users','UserController@store');
Route::put('/users/{id}','UserController@update');
Route::delete('/users/{id}', 'UserController@destroy');

// Clients Routes
Route::get('/clients', 'ClientController@index');
Route::get('/clients/{id}',  'ClientController@show');
Route::post('/clients','ClientController@store');
Route::put('/clients/{id}','ClientController@update');
Route::delete('/clients/{id}', 'ClientController@destroy');

// Brand Routes
Route::get('/brands', 'BrandController@index');
Route::get('/brands/{id}',  'BrandController@show');
Route::post('/brands','BrandController@store');
Route::put('/brands/{id}','BrandController@update');
Route::delete('/brands/{id}', 'BrandController@destroy');

// Campaigns Routes
Route::get('/campaigns', 'CampaignController@index');
Route::get('/campaigns/{id}',  'CampaignController@show');
Route::post('/campaigns','CampaignController@store');
Route::put('/campaigns/{id}','CampaignController@update');
Route::delete('/campaigns/{id}', 'CampaignController@destroy');


