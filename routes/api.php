<?php

use App\Contract;
use App\Project;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;
use App\User;
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
        Route::post('/attach/role', 'UsersController@attachRole');
        Route::post('/detach/role', 'UsersController@detachRole');
        Route::post('/attach/project', 'UsersController@attachProject');
        Route::post('/detach/project', 'UsersController@detachProject');
        Route::get('/count', function(){
            return User::count();
        });
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
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', 'RolesController@getRoles');
    });
    Route::group(['prefix' => 'projects'], function () {
        Route::get('/', 'ProjectsController@getProjects');
    });
    Route::group(['prefix' => 'admin'], function () {
        Route::post('/contracts', function(Request $request){
            return response()->json(Contract::create(['name' => $request->name]), 200);
        });
        Route::post('/contracts/update/{contract}', function(Contract $contract, Request $request){
            $contract->name = $request->name;
            $contract->save();
            return response()->json('Success', 200);
        });
        Route::post('/projects/update/{project}', 'AdminController@editProject');
        Route::get('/contracts/delete/{contract}', function(Contract $contract){
            $contract->delete();
            return response()->json('Success', 200);
        });
        Route::post('/projects', 'AdminController@addProject');
        Route::get('/projects/delete/{project}', function(Project $project){
            $project->delete();
            return response()->json('Success', 200);
        });
    });
});
