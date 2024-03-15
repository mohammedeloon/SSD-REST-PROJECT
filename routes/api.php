<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\API\V1\RoleController;
use App\Http\Controllers\API\V1\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerAuthController;
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

Route::controller(SellerAuthController::class)->group(function () {
    Route::post('/seller/login', 'login')->name('seller.login');
    Route::post('/seller/register', 'register')->name('seller.register');
});

Route::controller(AdminAuthController::class)->group(function () {
    Route::post('/admin/login', 'login')->name('admin.login');
    Route::post('/admin/register', 'register')->name('admin.register');
});


Route::post('/user/logout', [SellerAuthController::class, 'logout'])->middleware('auth:user');
Route::post('/seller/logout', [SellerAuthController::class, 'logout'])->middleware('auth:seller');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->middleware('auth:admin');



Route::get('products/show', [ProductController::class, 'index']); 
Route::get('products/show/{id}', [ProductController::class, 'show']); 

Route::middleware(['auth:user', 'role:admin', 'role:seller'])->prefix('products')->group(function () {
    Route::post('/store', [ProductController::class, 'store']);
    Route::put('/update/{id}', [ProductController::class, 'update']); 
    Route::delete('/delete/{id}', [ProductController::class, 'destroy']); 
});

Route::group(['middleware' => ['role:admin', 'permission:edit-product']], function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
});

Route::controller(RoleController::class)->middleware(['auth:user'])->group(function () {
    Route::get('/roles/show', 'index');
    Route::post('/roles/store', 'store');
    Route::get('/roles/{role}', 'show');
    Route::put('/roles/{role}', 'update');
    Route::delete('/roles/{role}', 'destroy');
    Route::post('/roles/{role}/permissions/give', 'givePermission');
    Route::delete('/roles/{role}/permissions/{permission}', 'revokePermission');
});

Route::controller(PermissionController::class)->middleware(['auth:user'])->group(function(){
    Route::get('/permissions/show', 'index');
    Route::post('/permissions/store', 'store');
    Route::get('/permissions/{permission}', 'show');
    Route::put('/permissions/{permission}', 'update');
    Route::delete('/permissions/{permission}', 'destroy');
    Route::post('/permissions/{permission}/roles/assign', 'assignRole');
    Route::delete('/permissions/{permission}/roles/{role}', 'removeRole');
});


