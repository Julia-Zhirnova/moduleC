<?php

use Illuminate\Http\Request;
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

Route::post('registration', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('authorization', [\App\Http\Controllers\AuthController::class, 'login']);


Route::group(['middleware' => 'MiddlewareAuth'], function () {
    Route::post('files', [\App\Http\Controllers\FileController::class, 'upload']);
   // Route::patch('files/{file_id}', [\App\Http\Controllers\FileController::class, 'update']);
   // Route::delete('files/{file_id}', [\App\Http\Controllers\FileController::class, 'destroy']);
   // Route::get('files/{file_id}', [\App\Http\Controllers\FileController::class, 'download']);
    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});