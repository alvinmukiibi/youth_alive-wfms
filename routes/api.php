<?php

use App\Attachment;
use App\Contract;
use App\Project;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;
use App\User;
use App\LeaveType;
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

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api',], function () {

    Route::group(['prefix' => 'users'], function () {
        Route::get('auth', function (Request $request) {
            return new ProfileResource($request->user());
        });
        Route::post('/save/profile', 'UsersController@saveProfile');
        Route::post('/save/dp/{user}', 'UsersController@saveDp');
        Route::post('/save/edit/{user}', 'UsersController@saveUserEdit');
        Route::get('/', 'UsersController@getUsers');
        Route::get('/activate/{user}', 'UsersController@activateUser');
        Route::get('/deactivate/{user}', 'UsersController@deactivateUser');
        Route::post('/add', 'UsersController@addUser');
        Route::post('/attach/role', 'UsersController@attachRole');
        Route::post('/detach/role', 'UsersController@detachRole');
        Route::post('/attach/project', 'UsersController@attachProject');
        Route::post('/detach/project', 'UsersController@detachProject');
        Route::get('/count', function () {
            return User::count();
        });
    });

    Route::group(['prefix' => 'departments'], function () {
        Route::get('/', 'DepartmentsController@getDepartments');
        Route::post('/', 'DepartmentsController@store');
        Route::post('/update/{department}', 'DepartmentsController@update');
    });
    Route::group(['prefix' => 'leaves'], function () {
        Route::get('/mine', 'LeavesController@getMyLeaves');
        Route::get('/pending', 'LeavesController@getPendingLeaves');
        Route::post('/', 'LeavesController@askForLeave');
        Route::get('/cancel/{leave}', 'LeavesController@cancelLeave');
        Route::post('/decline/{leave}', 'LeavesController@declineLeave');
        Route::get('/approve/{leave}', 'LeavesController@approveLeave');
    });
    Route::group(['prefix' => 'designations'], function () {
        Route::get('/', 'DesignationsController@getDesignations');
        Route::post('/', 'DesignationsController@store');
        Route::post('/update/{designation}', 'DesignationsController@update');
        Route::get('/delete/{designation}', 'DesignationsController@delete');
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

    Route::group(['prefix' => 'requests'], function () {
        Route::post('/', 'RequestsController@addRequest');
        Route::post('/update/{request}', 'RequestsController@updateRequest');
        Route::get('/mine', 'RequestsController@getMyRequests');
        Route::get('/accountant', 'RequestsController@getProjectRequests');
        Route::get('/firstlevel', 'RequestsController@getLevel1Requests');
        Route::get('/fmrequests', 'RequestsController@getFMRequests');
        Route::get('/directorreqeuests', 'RequestsController@getDirectorRequests');
        Route::get('/edrequests', 'RequestsController@getEDRequests');
        Route::post('/edrequests', 'RequestsController@approveRequest');
        Route::post('/directorreqeuests', 'RequestsController@approveRequest');
        Route::post('/fmrequests', 'RequestsController@approveRequest');
        Route::post('/firstlevel', 'RequestsController@approveRequest');
        Route::post('/accountant', 'RequestsController@approveRequest');
        Route::post('/decline', 'RequestsController@declineRequest');
    });

    Route::get('/download/file/{attachment}', function (Attachment $attachment) {
        // return Storage
        $ref = $attachment->reference;
        return response()->download(public_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $ref, 'Attachment.pdf', ['Content-Type' => 'application/pdf']);
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::post('/contracts', function (Request $request) {
            return response()->json(Contract::create(['name' => $request->name]), 200);
        });
        Route::post('/contracts/update/{contract}', function (Contract $contract, Request $request) {
            $contract->name = $request->name;
            $contract->save();
            return response()->json('Success', 200);
        });
        Route::post('/projects/update/{project}', 'AdminController@editProject');
        Route::get('/contracts/delete/{contract}', function (Contract $contract) {
            $contract->delete();
            return response()->json('Success', 200);
        });
        Route::post('/projects', 'AdminController@addProject');
        Route::get('/projects/delete/{project}', function (Project $project) {
            $project->delete();
            return response()->json('Success', 200);
        });

        Route::get('/leavetypes', function (Request $request) {
            return response()->json(LeaveType::all(), 202);
        });
        Route::get('/leavetypes/delete/{leaveType}', function (LeaveType $leaveType) {
            $leaveType->delete();
            return response()->json('', 202);
        });
        Route::post('/leavetypes', function (Request $request) {
            $leave = [
                'type' => $request->type,
                'days' => $request->days
            ];
            $leave = LeaveType::create($leave);
            return response()->json($leave, 202);
        });
        Route::post('/leavetypes/update/{leaveType}', function (LeaveType $leaveType, Request $request) {
            $leaveType->type = $request->type;
            $leaveType->days = $request->days;
            $leaveType->save();
            return response()->json($leaveType, 202);
        });

        Route::get('/assets', 'AdminController@getAssets');
        Route::post('/assets', 'AdminController@addAsset');
        Route::post('/assets/update/{asset}', 'AdminController@updateAsset');
        Route::get('/assets/delete/{asset}', 'AdminController@deleteAsset');

        Route::get('/vendors', 'AdminController@getVendors');
        Route::post('/vendors', 'AdminController@addVendor');
        Route::post('/vendors/update/{vendor}', 'AdminController@updateVendor');
        Route::get('/vendors/delete/{vendor}', 'AdminController@deleteVendor');
    });
});
