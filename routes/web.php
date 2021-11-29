<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/cache-fix',function(){
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('view:cache');
    dd("Cache Fixed Successfully");
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// home/user/store
Route::group(['middleware' => 'auth'],function(){

    Route::group(['middleware' => 'client'],function(){
    });

    Route::group(['middleware' => 'admin'],function(){
        Route::post('/home/user/store','HomeController@createuser');
    });
   
}); 