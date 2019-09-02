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
    return redirect('/login');
});


Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', 'AuthController@login');
    Route::post('/login', 'AuthController@authenticate');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->to('/login');
    });
    Route::get('/{any?}', function () {
        return view('app');
    })->where('any', '^(?!api\/)[\/\w\.-]*');
});
