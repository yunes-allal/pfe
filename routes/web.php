<?php

use App\Http\Models\Besoin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

//TODO supprimiha
Route::post('create-session',[App\Http\Controllers\SessionController::class, 'store'])->name('session');

Auth::routes();

Route::get('/', function (){return view('welcome');});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//! Sous directeur de personnel
// Expression des besoins
    //? 1. session
Route::get('session', [App\Http\Controllers\SessionController::class, 'index'])->name('session.index')->middleware('sdp');
Route::post('update-status', [App\Http\Controllers\SessionController::class, 'updateStatus'])->name('session.status.update')->middleware('sdp');

//? 2. besoins
Route::resource('besoins', 'App\Http\Controllers\BesoinController')->middleware('sdp');
    //? 3. les criteres
Route::resource('critères', 'App\Http\Controllers\CriteresController')->middleware('sdp');


//liste des candidats
Route::get('candidats', function(){return view('SDP.candidats');})->name('candidats')->middleware('sdp');

// Les commissions
Route::get('commissions', [App\Http\Controllers\CommissionController::class, 'index'])->name('commission.index')->middleware('sdp');
Route::get('créer-commissions', [App\Http\Controllers\CommissionController::class, 'createCommissions'])->name('commission.create')->middleware('sdp');
Route::get('commissions-mails', [App\Http\Controllers\CommissionController::class, 'sendAccounts'])->name('commission.mail')->middleware('sdp');


//! Candidat
Route::get('dossier', [App\Http\Controllers\DossierController::class, 'index'])->name('candidat.dossier')->middleware('candidat');
Route::get('créer-dossier', [App\Http\Controllers\DossierController::class, 'create'])->name('candidat.create.dossier')->middleware('candidat');
Route::post('mettre-à-jour-dossier', [App\Http\Controllers\DossierController::class, 'update'])->name('candidat.update.dossier')->middleware('candidat');
Route::post('dossier/ajouter-expérience-professionnel', [App\Http\Controllers\ExperienceProController::class, 'store'])->name('experience.store')->middleware('candidat');
Route::post('dossier/ajouter-formation-complémentaire', [App\Http\Controllers\FormationsCompController::class, 'store'])->name('formation.store')->middleware('candidat');
Route::post('dossier/ajouter-conférence', [App\Http\Controllers\ConferenceController::class, 'store'])->name('conference.store')->middleware('candidat');
Route::post('dossier/ajouter-revue', [App\Http\Controllers\ArticleController::class, 'store'])->name('revue.store')->middleware('candidat');


//! Commission de conformite

Route::get('liste-des-candidats', [App\Http\Controllers\CommissionController::class, 'getCandidates'])->name('liste.des.candidats');
Route::post('confome-dossier', [App\Http\Controllers\CommissionController::class, 'conformed'])->name('dossier.conformed');
Route::get('imprimer-pv-non-confomite', function (){
    $candidates = DB::select('SELECT dossiers.* FROM `besoins`, `commissions`, `dossiers` WHERE dossiers.besoin_id = besoins.id AND commissions.department_id = besoins.department_id AND commissions.email = "'.Auth::user()->email.'"AND dossiers.is_conformed!="1"');
    return view('commission.conformite.pv')->with('candidates', $candidates);
})->name('pv.non.conforme');

Route::get('imprimer-pv-conformite', function (){
    $candidates = DB::select('SELECT dossiers.* FROM `besoins`, `commissions`, `dossiers` WHERE dossiers.besoin_id = besoins.id AND commissions.department_id = besoins.department_id AND commissions.email = "'.Auth::user()->email.'"AND dossiers.is_conformed="1"');
    return view('commission.conformite.pv-conform')->with('candidates', $candidates);
})->name('pv.conforme');

//! commissions d'entretien
Route::post('noter-candidat', [App\Http\Controllers\NoteController::class, 'store'])->name('noter.candiat');
Route::get('imprimer-pv-entretien', function (){
    $session = Illuminate\Support\Facades\DB::table('sessions')->where('on_going','true')->select('id')->first();
    $candidates = DB::select('SELECT dossiers.* FROM `besoins`, `commissions`, `dossiers` WHERE dossiers.besoin_id = besoins.id AND commissions.department_id = besoins.department_id AND commissions.email = "'.Auth::user()->email.'" AND dossiers.is_conformed=1 AND '.$session->id.'= dossiers.session_id');
    return view('commission.entretien.pv')->with('candidates', $candidates);
})->name('pv.entretien');

