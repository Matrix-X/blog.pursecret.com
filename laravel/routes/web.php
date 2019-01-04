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





Route::group([

    'namespace' => "Web",
    'prefix' => 'oss',
//    'middleware' => 'client',
], function () {

    Route::get('test', "QiniuController@test")->name('oss.qiniu.read.test');
    Route::post('test', "QiniuController@test")->name('oss.qiniu.write.test');

    Route::get('getExternalLinks', "QiniuController@getExternalLinks")->name('oss.qiniu.read.getExternalLinks');
    Route::post('getExternalLinks', "QiniuController@getExternalLinks")->name('oss.qiniu.read.getExternalLinks');

});