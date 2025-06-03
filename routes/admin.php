<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LivreController;
use App\Http\Controllers\Admin\EmpruntController;
use App\Http\Controllers\Admin\RapportController;
use App\Http\Controllers\Admin\ParametreController;
use App\Http\Controllers\Admin\CategorieController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('users', UserController::class);
    Route::resource('livres', LivreController::class);
    Route::resource('emprunts', EmpruntController::class);
    Route::resource('categories', CategorieController::class);
    Route::get('/rapports', [RapportController::class, 'index'])->name('rapports');
    Route::get('/parametres', [ParametreController::class, 'index'])->name('parametres');
});

// Routes pour la gestion des utilisateurs
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
}); 