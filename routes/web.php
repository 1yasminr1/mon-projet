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
    Route::get('/login',               [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',              [AuthController::class, 'login']);
    Route::get('/register',            [AuthController::class, 'showRegisterApprenant'])->name('register');
    Route::post('/register',           [AuthController::class, 'registerApprenant']);
    Route::get('/register/formateur',  [AuthController::class, 'showRegisterFormateur'])->name('register.formateur');
    Route::post('/register/formateur', [AuthController::class, 'registerFormateur']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// ADMIN
// ==========================================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard',           [AdminController::class, 'index'])->name('dashboard');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/',                      [UserController::class, 'index'])->name('index');
        Route::post('/{user}/bloquer',       [UserController::class, 'bloquer'])->name('bloquer');
        Route::post('/{user}/debloquer',     [UserController::class, 'debloquer'])->name('debloquer');
        Route::delete('/{user}',             [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/notification',  [UserController::class, 'envoyerNotification'])->name('notification');
    });

    Route::prefix('formateurs')->name('formateurs.')->group(function () {
        Route::get('/',                      [UserController::class, 'formateurs'])->name('index');
        Route::post('/{user}/valider',       [UserController::class, 'validerFormateur'])->name('valider');
        Route::post('/{user}/rejeter',       [UserController::class, 'rejeterFormateur'])->name('rejeter');
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/',                      [CategorieController::class, 'index'])->name('index');
        Route::post('/',                     [CategorieController::class, 'store'])->name('store');
        Route::put('/{categorie}',           [CategorieController::class, 'update'])->name('update');
        Route::delete('/{categorie}',        [CategorieController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('sous-categories')->name('souscategories.')->group(function () {
        Route::post('/',                     [CategorieController::class, 'storeSousCategorie'])->name('store');
        Route::delete('/{sousCategorie}',    [CategorieController::class, 'destroySousCategorie'])->name('destroy');
    });

    Route::prefix('formations')->name('formations.')->group(function () {
        Route::get('/',                      [AdminInscriptionController::class, 'formations'])->name('index');
        Route::post('/{formation}/valider',  [AdminInscriptionController::class, 'validerFormation'])->name('valider');
        Route::post('/{formation}/rejeter',  [AdminInscriptionController::class, 'rejeterFormation'])->name('rejeter');
    });

    Route::prefix('inscriptions')->name('inscriptions.')->group(function () {
        Route::get('/',                      [AdminInscriptionController::class, 'index'])->name('index');
    });
});

// ==========================================
// FORMATEUR
// ==========================================
Route::middleware(['auth', 'formateur'])
    ->prefix('formateur')
    ->name('formateur.')
    ->group(function () {

    Route::get('/dashboard',           [FormateurController::class, 'index'])->name('dashboard');
    Route::get('/progression',         [FormateurController::class, 'progression'])->name('progression');

    Route::prefix('formations')->name('formations.')->group(function () {
        Route::get('/',                        [FormationController::class, 'index'])->name('index');
        Route::get('/create',                  [FormationController::class, 'create'])->name('create');
        Route::post('/',                       [FormationController::class, 'store'])->name('store');
        Route::get('/{formation}/edit',        [FormationController::class, 'edit'])->name('edit');
        Route::put('/{formation}',             [FormationController::class, 'update'])->name('update');
        Route::delete('/{formation}',          [FormationController::class, 'destroy'])->name('destroy');
        Route::get('/{formation}/modules',     [ModuleController::class, 'index'])->name('modules.index');
        Route::post('/{formation}/modules',    [ModuleController::class, 'store'])->name('modules.store');
        Route::get('/{formation}/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
        Route::post('/{formation}/evaluations',[EvaluationController::class, 'store'])->name('evaluations.store');
    });

    Route::prefix('modules')->name('modules.')->group(function () {
        Route::put('/{module}',                [ModuleController::class, 'update'])->name('update');
        Route::delete('/{module}',             [ModuleController::class, 'destroy'])->name('destroy');
        Route::post('/{module}/contenus',      [ModuleController::class, 'ajouterContenu'])->name('contenus.store');
    });

    Route::prefix('contenus')->name('contenus.')->group(function () {
        Route::delete('/{contenu}',            [ModuleController::class, 'supprimerContenu'])->name('destroy');
    });

    Route::prefix('evaluations')->name('evaluations.')->group(function () {
        Route::post('/{evaluation}/questions', [EvaluationController::class, 'ajouterQuestion'])->name('questions.store');
    });

    Route::prefix('inscriptions')->name('inscriptions.')->group(function () {
        Route::post('/{inscription}/certificat',[EvaluationController::class, 'attribuerCertificat'])->name('certificat.attribuer');
    });
    // Gestion Inscriptions Formateur
    Route::prefix('inscriptions')->name('inscriptions.')->group(function () {
    Route::get('/',                          [FormateurController::class, 'inscriptions'])->name('index');
    Route::post('/{inscription}/valider',    [FormateurController::class, 'validerInscription'])->name('valider');
    Route::post('/{inscription}/refuser',    [FormateurController::class, 'refuserInscription'])->name('refuser');
    Route::post('/{inscription}/certificat',[EvaluationController::class, 'attribuerCertificat'])->name('certificat.attribuer');
});
});

// ==========================================
// APPRENANT
// ==========================================
Route::middleware(['auth', 'apprenant'])
    ->prefix('apprenant')
    ->name('apprenant.')
    ->group(function () {

    Route::get('/dashboard',           [ApprenantController::class, 'index'])->name('dashboard');

    Route::prefix('formations')->name('formations.')->group(function () {
        Route::get('/',                        [InscriptionController::class, 'formations'])->name('index');
        Route::get('/{formation}',             [InscriptionController::class, 'detail'])->name('detail');
        Route::post('/{formation}/inscrire',   [InscriptionController::class, 'inscrire'])->name('inscrire');
        Route::get('/{formation}/contenu',     [InscriptionController::class, 'consulterContenu'])->name('contenu');
    });

    Route::prefix('inscriptions')->name('inscriptions.')->group(function () {
        Route::get('/',                        [InscriptionController::class, 'index'])->name('index');
        Route::post('/{inscription}/annuler',  [InscriptionController::class, 'annuler'])->name('annuler');
    });

    Route::prefix('certificats')->name('certificats.')->group(function () {
        Route::get('/',                        [CertificatController::class, 'index'])->name('index');
        Route::get('/{certificat}/telecharger',[CertificatController::class, 'telecharger'])->name('telecharger');
    });

    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::get('/{evaluation}',            [QuizController::class, 'show'])->name('show');
        Route::post('/{evaluation}/soumettre', [QuizController::class, 'soumettre'])->name('soumettre');
        Route::get('/{evaluation}/resultat',   [QuizController::class, 'resultat'])->name('resultat');
    });

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', function() {
            $notifications = \App\Models\Notification::where('user_id', \Illuminate\Support\Facades\Auth::id())
                                                      ->latest()->paginate(10);
            return view('apprenant.notifications.index', compact('notifications'));
        })->name('index');

        Route::post('/{notification}/lire', function(\App\Models\Notification $notification) {
            abort_if($notification->user_id !== \Illuminate\Support\Facades\Auth::id(), 403);
            $notification->update(['lu' => true]);
            return back();
        })->name('lire');

        Route::post('/lire-tout', function() {
            \App\Models\Notification::where('user_id', \Illuminate\Support\Facades\Auth::id())
                                     ->update(['lu' => true]);
            return back()->with('success', 'Toutes les notifications lues.');
        })->name('lire.tout');
    });
});