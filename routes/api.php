<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiTaskController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/auth'], function () {
    Route::post('/register', [ApiAuthController::class, 'register']);
    Route::post('/login', [ApiAuthController::class, 'login']);
    //TODO: logout
});

Route::group(['prefix' => '/task'], function () {
    Route::get('/', [\App\Http\Controllers\ApiTaskController::class, 'index'])->name('api.todo.get');
    Route::post('/', [\App\Http\Controllers\ApiTaskController::class, 'store'])->name('api.todo.store');
    Route::delete('/{id}', [\App\Http\Controllers\ApiTaskController::class, 'destroy'])->name('api.todo.destroy');
    Route::put('/{id}', [\App\Http\Controllers\ApiTaskController::class, 'update'])->name('api.todo.update');

    Route::get('/{id}/completed', [\App\Http\Controllers\ApiTaskController::class, 'completed'])->name('api.todo.done');

})->middleware('auth:sanctum');
