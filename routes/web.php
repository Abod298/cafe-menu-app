<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function (){
    return Inertia::render('Welcome');
})->name('home');




Route::group(['middleware' => ['auth', 'verified']] , function () {
    Route::get('dashboard', [DashboardController::class , 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users' , UserController::class);
    Route::resource('contacts', ContactController::class)
            ->only(['index', 'edit', 'update']);
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
Route::get('/{slug}', [MenuController::class , 'index']);
