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
    Route::get('/login', 'AuthController@login')->name('login');
    Route::post('/login', 'AuthController@authenticate');
    Route::get('/forgot', 'AuthController@forgotPassword');
    Route::post('/sendlink', 'AuthController@sendLink');
    Route::post('/reset', 'AuthController@doReset');
    Route::get('/password/reset/{token1}', 'AuthController@resetPassword');
    Route::get('/verify/email/{token}', 'AuthController@verifyEmail');

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
