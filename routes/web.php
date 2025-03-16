<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function (){
    return Inertia::render('Welcome');
})->name('home');




Route::group(['middleware' => ['auth', 'verified']] , function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('contacts', ContactController::class)
            ->only(['index', 'edit', 'update']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
Route::get('/{slug}', [MenuController::class , 'index']);
