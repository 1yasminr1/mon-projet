<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\InscriptionController as AdminInscriptionController;
use App\Http\Controllers\Formateur\FormateurController;
use App\Http\Controllers\Formateur\FormationController;
use App\Http\Controllers\Formateur\ModuleController;
use App\Http\Controllers\Formateur\EvaluationController;
use App\Http\Controllers\Apprenant\ApprenantController;
use App\Http\Controllers\Apprenant\InscriptionController;
use App\Http\Controllers\Apprenant\CertificatController;
use App\Http\Controllers\Apprenant\QuizController;

// ==========================================
// PAGE PUBLIQUE
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ==========================================
// AUTHENTIFICATION
// ==========================================
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register Apprenant
    Route::get('/register',  [AuthController::class, 'showRegisterApprenant'])->name('register');
    Route::post('/register', [AuthController::class, 'registerApprenant']);

    // Register Formateur
    Route::get('/register/formateur',  [AuthController::class, 'showRegisterFormateur'])->name('register.formateur');
    Route::post('/register/formateur', [AuthController::class, 'registerFormateur']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// ADMIN
// ==========================================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Gestion Utilisateurs
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/',                      [UserController::class, 'index'])->name('index');
        Route::post('/{user}/bloquer',       [UserController::class, 'bloquer'])->name('bloquer');
        Route::post('/{user}/debloquer',     [UserController::class, 'debloquer'])->name('debloquer');
        Route::delete('/{user}',             [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/notification',  [UserController::class, 'envoyerNotification'])->name('notification');
    });

    // Gestion Formateurs
    Route::prefix('formateurs')->name('formateurs.')->group(function () {
        Route::get('/',              [UserController::class, 'formateurs'])->name('index');
        Route::post('/{user}/valider',[UserController::class, 'validerFormateur'])->name('valider');
        Route::post('/{user}/rejeter',[UserController::class, 'rejeterFormateur'])->name('rejeter');
    });

    // Gestion Categories
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/',                [CategorieController::class, 'index'])->name('index');
        Route::post('/',               [CategorieController::class, 'store'])->name('store');
        Route::put('/{categorie}',     [CategorieController::class, 'update'])->name('update');
        Route::delete('/{categorie}',  [CategorieController::class, 'destroy'])->name('destroy');
    });

    // Gestion Sous-Categories
    Route::prefix('sous-categories')->name('souscategories.')->group(function () {
        Route::post('/',                      [CategorieController::class, 'storeSousCategorie'])->name('store');
        Route::delete('/{sousCategorie}',     [CategorieController::class, 'destroySousCategorie'])->name('destroy');
    });

    // Validation Formations
    Route::prefix('formations')->name('formations.')->group(function () {
        Route::get('/',                      [AdminInscriptionController::class, 'formations'])->name('index');
        Route::post('/{formation}/valider',  [AdminInscriptionController::class, 'validerFormation'])->name('valider');
        Route::post('/{formation}/rejeter',  [AdminInscriptionController::class, 'rejeterFormation'])->name('rejeter');
    });

    // Gestion Inscriptions
    Route::prefix('inscriptions')->name('inscriptions.')->group(function () {
        Route::get('/', [AdminInscriptionController::class, 'index'])->name('index');
    });
});

// ==========================================
// FORMATEUR
// ==========================================
Route::middleware(['auth', 'formateur'])
    ->prefix('formateur')
    ->name('formateur.')
    ->group(function () {

    // Dashboard
    Route::get('/dashboard',   [FormateurController::class, 'index'])->name('dashboard');
    Route::get('/progression', [FormateurController::class, 'progression'])->name('progression');

    // Gestion Formations
    Route::prefix('formations')->name('formations.')->group(function () {
        Route::get('/',              [FormationController::class, 'index'])->name('index');
        Route::get('/create',        [FormationController::class, 'create'])->name('create');
        Route::post('/',             [FormationController::class, 'store'])->name('store');
        Route::get('/{formation}/edit',   [FormationController::class, 'edit'])->name('edit');
        Route::put('/{formation}',        [FormationController::class, 'update'])->name('update');
        Route::delete('/{formation}',     [FormationController::class, 'destroy'])->name('destroy');

        // Modules de la formation
        Route::get('/{formation}/modules',  [ModuleController::class, 'index'])->name('modules.index');
        Route::post('/{formation}/modules', [ModuleController::class, 'store'])->name('modules.store');

        // Evaluations de la formation
        Route::get('/{formation}/evaluations',  [EvaluationController::class, 'index'])->name('evaluations.index');
        Route::post('/{formation}/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
    });

    // Gestion Modules
    Route::prefix('modules')->name('modules.')->group(function () {
        Route::put('/{module}',    [ModuleController::class, 'update'])->name('update');
        Route::delete('/{module}', [ModuleController::class, 'destroy'])->name('destroy');
        Route::post('/{module}/contenus', [ModuleController::class, 'ajouterContenu'])->name('contenus.store');
    });

    // Gestion Contenus
    Route::prefix('contenus')->name('contenus.')->group(function () {
        Route::delete('/{contenu}', [ModuleController::class, 'supprimerContenu'])->name('destroy');
    });

    // Gestion Evaluations
    Route::prefix('evaluations')->name('evaluations.')->group(function () {
        Route::post('/{evaluation}/questions', [EvaluationController::class, 'ajouterQuestion'])->name('questions.store');
    });

    // Certificats
    Route::prefix('inscriptions')->name('inscriptions.')->group(function () {
        Route::post('/{inscription}/certificat', [EvaluationController::class, 'attribuerCertificat'])->name('certificat.attribuer');
    });
});

// ==========================================
// APPRENANT
// ==========================================
Route::middleware(['auth', 'apprenant'])
    ->prefix('apprenant')
    ->name('apprenant.')
    ->group(function () {

    // Dashboard
    Route::get('/dashboard', [ApprenantController::class, 'index'])->name('dashboard');

    // Formations disponibles
    Route::prefix('formations')->name('formations.')->group(function () {
        Route::get('/',                          [InscriptionController::class, 'formations'])->name('index');
        Route::get('/{formation}',               [InscriptionController::class, 'detail'])->name('detail');
        Route::post('/{formation}/inscrire',     [InscriptionController::class, 'inscrire'])->name('inscrire');
        Route::get('/{formation}/contenu',       [InscriptionController::class, 'consulterContenu'])->name('contenu');
    });

    // Mes Inscriptions
    Route::prefix('inscriptions')->name('inscriptions.')->group(function () {
        Route::get('/',                          [InscriptionController::class, 'index'])->name('index');
        Route::post('/{inscription}/annuler',    [InscriptionController::class, 'annuler'])->name('annuler');
    });

    // Certificats
    Route::prefix('certificats')->name('certificats.')->group(function () {
        Route::get('/',                              [CertificatController::class, 'index'])->name('index');
        Route::get('/{certificat}/telecharger',      [CertificatController::class, 'telecharger'])->name('telecharger');
    });

    // Quiz / Examens
    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::get('/{evaluation}',              [QuizController::class, 'show'])->name('show');
        Route::post('/{evaluation}/soumettre',   [QuizController::class, 'soumettre'])->name('soumettre');
        Route::get('/{evaluation}/resultat',     [QuizController::class, 'resultat'])->name('resultat');
    });
});