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

// Officials API Routes
Route::prefix('officials')->group(function () {
    Route::get('/', [App\Http\Controllers\OfficialController::class, 'index']);
    Route::get('/create', [App\Http\Controllers\OfficialController::class, 'create']);
    Route::post('/', [App\Http\Controllers\OfficialController::class, 'store']);
    Route::get('/{id}', [App\Http\Controllers\OfficialController::class, 'show']);
    Route::get('/{id}/edit', [App\Http\Controllers\OfficialController::class, 'edit']);
    Route::put('/{id}', [App\Http\Controllers\OfficialController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\OfficialController::class, 'destroy']);
    Route::post('/{id}/restore', [App\Http\Controllers\OfficialController::class, 'restore']);
});
