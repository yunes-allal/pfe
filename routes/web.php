<?php

use App\Http\Models\Besoin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['update.status']], function() {

    Route::get('/', function (){return view('welcome');});

    Route::get('/inbox', function(){return view('layouts.inbox')->with('user', Auth::id());})->name('inbox');
    Route::post('/send-message', [App\Http\Controllers\MessageController::class, 'store'])->name('send.message');
});

//! Sous directeur de personnel
Route::group(['middleware' => ['update.status', 'sdp']], function() {
// Expression des besoins
    //? 1. session
    Route::get('session', [App\Http\Controllers\SessionController::class, 'index'])->name('session.index');
    Route::post('create-session',[App\Http\Controllers\SessionController::class, 'store'])->name('session');
    Route::post('update-status', [App\Http\Controllers\SessionController::class, 'updateStatus'])->name('session.status.update');

    //? 2. besoins
    Route::resource('besoins', 'App\Http\Controllers\BesoinController');
        //? 3. les criteres
    Route::resource('critères', 'App\Http\Controllers\CriteresController');


    //liste des candidats
    Route::get('candidats', function(){return view('SDP.candidats');})->name('candidats');

    // Les commissions
    Route::get('commissions', [App\Http\Controllers\CommissionController::class, 'index'])->name('commission.index');
    Route::get('créer-commissions', [App\Http\Controllers\CommissionController::class, 'createCommissions'])->name('commission.create');
    Route::get('commissions-mails', [App\Http\Controllers\CommissionController::class, 'sendAccounts'])->name('commission.mail');
    Route::get('commissions-renvoyée-mails', [App\Http\Controllers\CommissionController::class, 'resendAccounts'])->name('commission.redo.mail');
    Route::get('commissions-update-state', [App\Http\Controllers\CommissionController::class, 'updateState'])->name('commission.update.state');

    //Les PVs
    Route::get('PVs', function(){return view('SDP.pvs');})->name('pvs');
    Route::get('PVs-confomite', function(){return view('SDP.pvs.pvs-conformite');})->name('pvs.confomite');
    // Deliberation finale

    Route::get('délibération-finale', function(){return view('SDP.dileberation-finale');})->name('deliberation.finale');

});

//! Candidat
Route::group(['middleware' => ['update.status', 'auth', 'candidat']], function() {
    Route::get('dossier', [App\Http\Controllers\DossierController::class, 'index'])->name('candidat.dossier');
    Route::get('créer-dossier', [App\Http\Controllers\DossierController::class, 'create'])->name('candidat.create.dossier');
    Route::post('mettre-à-jour-dossier', [App\Http\Controllers\DossierController::class, 'update'])->name('candidat.update.dossier');
    Route::post('dossier/ajouter-expérience-professionnel', [App\Http\Controllers\ExperienceProController::class, 'store'])->name('experience.store');
    Route::post('dossier/ajouter-formation-complémentaire', [App\Http\Controllers\FormationsCompController::class, 'store'])->name('formation.store');
    Route::post('dossier/ajouter-conférence', [App\Http\Controllers\ConferenceController::class, 'store'])->name('conference.store');
    Route::post('dossier/ajouter-revue', [App\Http\Controllers\ArticleController::class, 'store'])->name('revue.store');
    Route::post('valider-dossier', [App\Http\Controllers\DossierController::class, 'validateFolder'])->name('validate.dossier');
});




//! Commission de conformite

Route::get('liste-des-candidats', [App\Http\Controllers\CommissionController::class, 'getCandidates'])->name('liste.des.candidats');
Route::post('confome-dossier', [App\Http\Controllers\CommissionController::class, 'conformed'])->name('dossier.conformed');

//Imprimer les pvs
Route::get('imprimer-pv-non-confomite', function (){
    $candidates = DB::select('SELECT dossiers.* FROM `besoins`, `commissions`, `dossiers` WHERE dossiers.besoin_id = besoins.id AND commissions.department_id = besoins.department_id AND commissions.email = "'.Auth::user()->email.'"AND dossiers.is_conformed!="1"');
    return view('commission.conformite.pv')->with('candidates', $candidates);
})->name('pv.non.conforme');

Route::get('imprimer-pv-conformite', function (){
    $candidates = DB::select('SELECT dossiers.* FROM `besoins`, `commissions`, `dossiers` WHERE dossiers.besoin_id = besoins.id AND commissions.department_id = besoins.department_id AND commissions.email = "'.Auth::user()->email.'"AND dossiers.is_conformed="1"');
    return view('commission.conformite.pv-conform')->with('candidates', $candidates);
})->name('pv.conforme');

//! commissions d'entretien
Route::post('noter-candidat', [App\Http\Controllers\NoteController::class, 'storeEntretien'])->name('noter.candiat');
Route::get('imprimer-pv-entretien', function (){
    $session = Illuminate\Support\Facades\DB::table('sessions')->where('status', '!=', 'off')->select('id')->first();
    $candidates = DB::select('SELECT dossiers.* FROM `besoins`, `commissions`, `dossiers` WHERE dossiers.besoin_id = besoins.id AND commissions.department_id = besoins.department_id AND commissions.email = "'.Auth::user()->email.'" AND dossiers.is_conformed=1 AND '.$session->id.'= dossiers.session_id');
    return view('commission.entretien.pv')->with('candidates', $candidates);
})->name('pv.entretien');

//! commissions de validation les traveaux scientifiques

Route::post('noter-traveaux', [App\Http\Controllers\NoteController::class, 'storeTrav'])->name('noter.traveaux');
