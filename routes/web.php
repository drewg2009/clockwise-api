<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});
Route::get('get/allVoices','VoiceController@getAllVoices');



Route::post('get/moduleData', 'AggregatorController@executeAll');
Route::post('get/introMessage', 'AmazonPollyController@getIntroMessage');
Route::post('get/errorMessage','AmazonPollyController@getErrorMessage');
Route::post('get/nearbyLocations','GooglePlacesController@getNearbyLocations');
