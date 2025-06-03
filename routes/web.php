<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\AuteurController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\RecommandationController;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AccueilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route d'accueil
Route::get('/', [AccueilController::class, 'index'])->name('accueil');

// Routes d'authentification
require __DIR__.'/auth.php';

// Routes nécessitant une authentification
Route::middleware(['auth', 'verified'])->group(function () {
    // Redirection dashboard selon rôle
    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin() 
            ? redirect()->route('admin.dashboard')
            : redirect()->route('membre.dashboard');
    })->name('dashboard');

    // Routes communes à tous les utilisateurs authentifiés
    Route::get('/recherche', [RechercheController::class, 'index'])->name('recherche.index');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/historique', [HistoriqueController::class, 'index'])->name('historique.index');
    
    // Gestion du profil
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Zone MEMBRE
    Route::middleware([\App\Http\Middleware\EnsureUserIsMembre::class])->prefix('membre')->name('membre.')->group(function () {
        // Dashboard membre
        Route::get('/dashboard', [DashboardController::class, 'membre'])->name('dashboard');
        
        // Recommandations membre
        Route::get('/recommandations', [RecommandationController::class, 'index'])->name('recommandations.index');
        
        // Historique
        Route::get('/historique', [HistoriqueController::class, 'empruntHistorique'])->name('historique.index');
    });

    // Zone ADMIN
    Route::middleware([\App\Http\Middleware\EnsureIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard admin
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');
        
        // Gestion des ressources
        Route::resource('livres', App\Http\Controllers\Admin\LivreController::class);
        Route::resource('auteurs', AuteurController::class);
        Route::resource('categories', CategorieController::class);
        Route::resource('emprunts', App\Http\Controllers\Admin\EmpruntController::class);
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        
        // Routes spécifiques admin
        Route::patch('/emprunts/{emprunt}/retour', [App\Http\Controllers\Admin\EmpruntController::class, 'retour'])
            ->name('emprunts.retour');
        Route::get('/emprunts/retards', [App\Http\Controllers\Admin\EmpruntController::class, 'retards'])
            ->name('emprunts.retards');
        
        // Rapports
        Route::get('/rapports', [App\Http\Controllers\Admin\RapportController::class, 'index'])
            ->name('rapports');
    });
});