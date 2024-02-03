<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group([
    'middleware' => 'web',
    'prefix' => 'export',
], function ($router) {
    Route::get('devices', \App\Http\Controllers\ReportControllers\DevicesReportController::class);
    Route::get('racks', \App\Http\Controllers\ReportControllers\RacksReportController::class);
});

Route::get('/', function () {
    return 'Container healthcheck OK';
});
