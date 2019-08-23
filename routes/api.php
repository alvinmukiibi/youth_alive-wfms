<?php

use App\Http\Resources\ProfileResource;
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

Route::group(['middleware' => ['auth:api'], 'namespace' => 'Api', ], function () {

    Route::group(['prefix' => 'users'], function () {
        Route::get('auth', function (Request $request) {
            return new ProfileResource($request->user());
        });
        Route::post('/save/profile', 'UsersController@saveProfile');
        Route::post('/save/edit/{user}', 'UsersController@saveUserEdit');
        Route::get('/', 'UsersController@getUsers');
        Route::get('/activate/{user}', 'UsersController@activateUser');
        Route::get('/deactivate/{user}', 'UsersController@deactivateUser');
        Route::post('/add', 'UsersController@addUser');
    });

    Route::group(['prefix' => 'departments'], function () {
        Route::get('/', 'DepartmentsController@getDepartments');
    });
    Route::group(['prefix' => 'designations'], function () {
        Route::get('/', 'DesignationsController@getDesignations');
    });
    Route::group(['prefix' => 'contracts'], function () {
        Route::get('/', 'ContractsController@getContracts');
    });
});
