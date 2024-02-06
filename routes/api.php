<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'api',
], function ($router) {
    /*
    |--------------------------------------------------------------------------
    | API v1
    |--------------------------------------------------------------------------
    */
    Route::group([
        'prefix' => 'v1',
    ], function ($router) {
        Route::group([
            'prefix' => 'auth',
        ], function ($router) {
            /*
            |--------------------------------------------------------------------------
            | DEVICE
            |--------------------------------------------------------------------------
            */
            Route::group([
                'prefix' => 'device',
            ], function ($router) {
                Route::post('', \App\Http\Controllers\DeviceControllers\CreateDeviceController::class);
                Route::patch('{id}', \App\Http\Controllers\DeviceControllers\UpdateDeviceController::class)
                    ->where(['id' => '[0-9]+']);
                Route::get('{id}', \App\Http\Controllers\DeviceControllers\GetDeviceController::class)
                    ->where(['id' => '[0-9]+']);
                Route::delete('{id}', \App\Http\Controllers\DeviceControllers\DeleteDeviceController::class)
                    ->where(['id' => '[0-9]+']);
                Route::get('{id}/location', \App\Http\Controllers\DeviceControllers\GetDeviceLocationController::class)
                    ->where(['id' => '[0-9]+']);
                Route::get('vendors', \App\Http\Controllers\DeviceControllers\GetDeviceVendorsController::class);
                Route::get('models', \App\Http\Controllers\DeviceControllers\GetDeviceModelsController::class);
            });
            /*
            |--------------------------------------------------------------------------
            | RACK
            |--------------------------------------------------------------------------
            */
            Route::group([
                'prefix' => 'rack',
            ], function ($router) {
                Route::post('', \App\Http\Controllers\RackControllers\CreateRackController::class);
                Route::get('{id}', \App\Http\Controllers\RackControllers\GetRackController::class)
                    ->where(['id' => '[0-9]+']);
                Route::delete('{id}', \App\Http\Controllers\RackControllers\DeleteRackController::class)
                    ->where(['id' => '[0-9]+']);
                Route::patch('{id}', \App\Http\Controllers\RackControllers\UpdateRackController::class)
                    ->where(['id' => '[0-9]+']);
                Route::get('{id}/location', \App\Http\Controllers\RackControllers\GetRackLocationController::class)
                    ->where(['id' => '[0-9]+']);
                Route::get('vendors', \App\Http\Controllers\RackControllers\GetRackVendorsController::class);
                Route::get('models', \App\Http\Controllers\RackControllers\GetRackModelsController::class);
                Route::get('{id}/devices', \App\Http\Controllers\RackControllers\GetRackDevicesController::class)
                    ->where(['id' => '[0-9]+']);
                Route::get('all/{per_page}', \App\Http\Controllers\RackControllers\GetAllRacksController::class)
                    ->where(['per_page' => '[0-9]+']);
            });
            /*
            |--------------------------------------------------------------------------
            | SITE
            |--------------------------------------------------------------------------
            */
            Route::group([
                'prefix' => 'site',
            ], function ($router) {
                Route::post('', \App\Http\Controllers\SiteControllers\CreateSiteController::class);
                Route::get('{id}', \App\Http\Controllers\SiteControllers\GetSiteController::class)
                    ->where(['id' => '[0-9]+']);
                Route::delete('{id}', \App\Http\Controllers\SiteControllers\DeleteSiteController::class)
                    ->where(['id' => '[0-9]+']);
                Route::patch('{id}', \App\Http\Controllers\SiteControllers\UpdateSiteController::class)
                    ->where(['id' => '[0-9]+']);
                Route::get('all/{per_page}', \App\Http\Controllers\SiteControllers\GetAllSitesController::class)
                    ->where(['per_page' => '[0-9]+']);
            });
            /*
            |--------------------------------------------------------------------------
            | BUILDING
            |--------------------------------------------------------------------------
            */
            Route::group([
                'prefix' => 'building',
            ], function ($router) {
                Route::post('', \App\Http\Controllers\BuildingControllers\CreateBuildingController::class);
                Route::get('{id}', \App\Http\Controllers\BuildingControllers\GetBuildingController::class)
                    ->where(['id' => '[0-9]+']);
                Route::delete('{id}', \App\Http\Controllers\BuildingControllers\DeleteBuildingController::class)
                    ->where(['id' => '[0-9]+']);
                Route::patch('{id}', \App\Http\Controllers\BuildingControllers\UpdateBuildingController::class)
                    ->where(['id' => '[0-9]+']);
                Route::get('all/{per_page}', \App\Http\Controllers\BuildingControllers\GetAllBuildingsController::class)
                    ->where(['per_page' => '[0-9]+']);
            });
            /*
            |--------------------------------------------------------------------------
            | ROOM
            |--------------------------------------------------------------------------
            */
            Route::group([
                'prefix' => 'room',
            ], function ($router) {
                Route::post('', \App\Http\Controllers\RoomControllers\CreateRoomController::class);
                Route::get('{id}', \App\Http\Controllers\RoomControllers\GetRoomController::class)
                    ->where(['id' => '[0-9]+']);
                Route::delete('{id}', \App\Http\Controllers\RoomControllers\DeleteRoomController::class)
                    ->where(['id' => '[0-9]+']);
                Route::patch('{id}', \App\Http\Controllers\RoomControllers\UpdateRoomController::class)
                    ->where(['id' => '[0-9]+']);
                Route::get('all/{per_page}', \App\Http\Controllers\RoomControllers\GetAllRoomsController::class)
                    ->where(['per_page' => '[0-9]+']);
            });
            /*
            |--------------------------------------------------------------------------
            | REGION
            |--------------------------------------------------------------------------
            */
            Route::group([
                'prefix' => 'region',
            ], function ($router) {
                Route::get('{id}', \App\Http\Controllers\RegionControllers\GetRegionController::class)
                    ->where(['id' => '[0-9]+']);
                Route::get('all/{per_page}', \App\Http\Controllers\RegionControllers\GetAllRegionsController::class)
                    ->where(['per_page' => '[0-9]+']);
            });
            /*
            |--------------------------------------------------------------------------
            | DEPARTMENT
            |--------------------------------------------------------------------------
            */
            Route::group([
                'prefix' => 'department',
            ], function ($router) {
                Route::get('{id}', \App\Http\Controllers\DepartmentControllers\GetDepartmentController::class)
                    ->where(['id' => '[0-9]+']);
                Route::get('all/{per_page}', \App\Http\Controllers\DepartmentControllers\GetAllDepartmentsController::class)
                    ->where(['per_page' => '[0-9]+']);
            });
            /*
            |--------------------------------------------------------------------------
            | USER
            |--------------------------------------------------------------------------
            */
            Route::group([
                'prefix' => 'user',
            ], function ($router) {
                Route::get('', \App\Http\Controllers\UserControllers\GetUserController::class);
                Route::get('all/{per_page}', \App\Http\Controllers\UserControllers\GetAllUsersController::class)
                    ->where(['per_page' => '[0-9]+']);
            });

            Route::get('tree', \App\Http\Controllers\RegionControllers\GetTreeViewController::class);

            Route::post('login', [AuthController::class, 'login']);
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('refresh', [AuthController::class, 'refresh']);

        });
    });
});
