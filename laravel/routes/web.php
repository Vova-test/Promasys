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

// User Authentication Routes
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');

Route::group(['middleware' => ['auth']], function () {

    /*Route::get('/', function () {
        return redirect()->route('/projects');
    });*/
    Route::redirect('/', '/projects');
    Route::get('/test','ProjectController@test');

    Route::prefix('/projects')->group(function () {
        Route::get('/','ProjectController@index')->name('projects');
        Route::post('/','ProjectController@getProjects');

        Route::get('/open','ProjectController@open')->name('projects.open');

        Route::post('/store','ProjectController@store')->name('projects.store');
        Route::post('/update/{id}','ProjectController@update')->name('projects.update');

        Route::delete('/delete/{id}','ProjectController@destroy')->name('projects.delete');
    });

    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::post('panic', 'PanicController@index')->name('panic');
});
