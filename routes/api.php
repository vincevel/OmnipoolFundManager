<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/update/baddress',[App\Http\Controllers\Api\ProfileUpdateController::class, 'update_baddress']); 
Route::post('/update/deferred1',[App\Http\Controllers\Api\ProfileUpdateController::class, 'update_deferred1']); 
Route::post('/update/deferred2',[App\Http\Controllers\Api\ProfileUpdateController::class, 'update_deferred2']); 
Route::post('/update/changeinterestrate',[App\Http\Controllers\Api\ProfileUpdateController::class, 'changeinterestrate']); 


