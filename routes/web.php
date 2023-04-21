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

Route::get('/', 'App\Http\Controllers\WelcomeController@index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('mygroup')->group(function () {
	Route::group(['middleware'=>'auth'], function(){ //untuk 
        Route::get('/', 'App\Http\Controllers\GroupController@index');
        Route::get('/create', 'App\Http\Controllers\GroupController@form');
        Route::post('/store/{id?}', 'App\Http\Controllers\GroupController@store');
        Route::post('/gridview', 'App\Http\Controllers\GroupController@gridview');
        Route::post('/gridview_listmember', 'App\Http\Controllers\GroupController@gridview_listmember');
        Route::get('/invite_people/{id?}', 'App\Http\Controllers\GroupController@invite_people');
        Route::post('/send_email', 'App\Http\Controllers\GroupController@send_email');
        Route::get('/edit/{id}', 'App\Http\Controllers\GroupController@form');
    });      
});

Route::prefix('event')->group(function () {
    Route::group(['middleware'=>'auth'], function(){ //untuk 
        Route::get('/', 'App\Http\Controllers\EventController@index');
        Route::get('/create', 'App\Http\Controllers\EventController@form');
        Route::post('/store/{id?}', 'App\Http\Controllers\EventController@store');
        Route::post('/gridview', 'App\Http\Controllers\EventController@gridview');
        Route::get('/show/{id}', 'App\Http\Controllers\EventController@show');
        // Route::post('/gridview_listmember', 'App\Http\Controllers\GroupController@gridview_listmember');
        // Route::get('/invite_people/{id?}', 'App\Http\Controllers\GroupController@invite_people');
        // Route::post('/send_email', 'App\Http\Controllers\GroupController@send_email');
        Route::get('/edit/{id}', 'App\Http\Controllers\EventController@form');
    });      
});
