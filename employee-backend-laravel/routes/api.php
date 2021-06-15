<?php

use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\UserController;
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



//Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group( function () {

    Route::get('/user' , [UserController::class , 'show']);

    Route::get('employees', [EmployeeController::class , 'index']);
    Route::prefix('employee')->group(function (){
        Route::get('/{id}' , [EmployeeController::class , 'show']);
        Route::post('/', [EmployeeController::class , 'store']);
        Route::put('/{id}', [EmployeeController::class , 'update']);
        Route::delete('/{id}', [EmployeeController::class , 'destroy']);

    });
});
