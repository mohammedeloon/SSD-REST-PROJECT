<?php

use App\Http\Controllers\API\V1\RoleController;
use App\Http\Controllers\API\V1\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserAuthController;
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

Route::controller(UserAuthController::class)->group(function () {
    Route::post('/user/login', 'login')->name('user.login');
    Route::post('/user/register', 'register')->name('user.register');
});


Route::post('/user/logout', [UserAuthController::class, 'logout'])->middleware('auth:user');


Route::get('products/show', [ProductController::class, 'index']); 
Route::get('products/show/{id}', [ProductController::class, 'show']); 

Route::middleware(['auth:user', 'role:admin', 'role:seller'])->prefix('products')->group(function () {
    Route::post('/store', [ProductController::class, 'store']);
    Route::put('/update/{id}', [ProductController::class, 'update']); 
    Route::delete('/delete/{id}', [ProductController::class, 'destroy']); 
});

Route::controller(RoleController::class)->middleware(['auth:user', 'role:admin'])->group(function () {
    Route::get('/roles/show', 'index');
    Route::post('/roles/store', 'store');
    Route::get('/roles/{role}', 'show');
    Route::put('/roles/{role}', 'update');
    Route::delete('/roles/{role}', 'destroy');
    Route::post('/roles/{role}/permissions/give', 'givePermission');
    Route::delete('/roles/{role}/permissions/{permission}', 'revokePermission');
});

Route::controller(PermissionController::class)->middleware(['auth:user', 'role:admin'])->group(function(){
    Route::get('/permissions/show', 'index');
    Route::post('/permissions/store', 'store');
    Route::get('/permissions/{permission}', 'show');
    Route::put('/permissions/{permission}', 'update');
    Route::delete('/permissions/{permission}', 'destroy');
    Route::post('/permissions/{permission}/roles/assign', 'assignRole');
    Route::delete('/permissions/{permission}/roles/{role}', 'removeRole');
});


