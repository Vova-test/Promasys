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
Route::get('/login', 'Auth\LoginController@showLoginForm')
    ->name('login');
Route::post('/login', 'Auth\LoginController@login');

Route::group(['middleware' => ['auth']], function () {

    Route::redirect('/', '/projects');

    //Route::get('/test','ProjectController@test');

    Route::prefix('/projects')->group(function () {
        Route::get('/','ProjectController@index')
            ->name('projects');
        Route::post('/','ProjectController@getProjects');

        Route::post('/store','ProjectController@store')
            ->name('project.store');
        Route::post('/update/{id}','ProjectController@update')
            ->name('project.update');
        Route::delete('/delete/{id}','ProjectController@destroy')
            ->name('project.delete');

        Route::get('/card/{id}','ProjectController@show')
            ->name('project.card');
    });

    Route::prefix('/credentials')->group(function () {
        Route::post('/list/{project}','CredentialSetController@getCredentials')
            ->name('credentials');

        Route::post('/store','CredentialSetController@store')
            ->name('credential.store');
        Route::post('/update/{id}','CredentialSetController@update')
            ->name('credential.update');

        Route::delete('/delete/{id}','CredentialSetController@destroy')
            ->name('credential.delete');
    });

    Route::prefix('/settings')->group(function () {
        Route::get('/{project}','ProjectSettingController@index')
            ->name('settings');
        Route::post('/{project}','ProjectSettingController@getSettings');

        Route::post('/store','ProjectSettingController@store')
            ->name('settings.store');
        Route::delete('/delete/{id}','ProjectSettingController@destroy')
            ->name('settings.delete');
    });

    Route::post('logout', 'Auth\LoginController@logout')
        ->name('logout');

    Route::post('panic', 'PanicController@index')
        ->name('panic');
});
