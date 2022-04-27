<?php

use App\Mail\Commission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Besoin;

//TODO supprimiha
Route::post('create-session',[App\Http\Controllers\SessionController::class, 'store'])->name('session');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Route::get('besoins/delete',[App\Http\Controllers\BesoinController::class, 'destroy'])->name('besoins.destroy');
Route::get('/', function (){return view('SDP.index');})->name('index');

//! Sous directeur de personnel
// Expression des besoins
Route::get('session', [App\Http\Controllers\SessionController::class, 'index'])->name('session.index');
Route::resource('besoins', 'App\Http\Controllers\BesoinController');

//liste des candidats
Route::get('candidats', function(){
    return view('SDP.candidats');
})->name('candidats');

// Les commissions
Route::get('commissions', [App\Http\Controllers\CommissionController::class, 'index'])->name('commission.index');
Route::get('creer-commissions', [App\Http\Controllers\CommissionController::class, 'createCommissions'])->name('commission.create');
Route::get('commissions-mails', [App\Http\Controllers\CommissionController::class, 'sendAccounts'])->name('commission.mail');




Route::resource('criteres', 'App\Http\Controllers\GlobalcriteriasController');

