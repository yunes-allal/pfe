<?php

use Illuminate\Support\Facades\Route;

Route::post('create-session',[App\Http\Controllers\SessionController::class, 'store'])->name('session');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Route::get('besoins/delete',[App\Http\Controllers\BesoinController::class, 'destroy'])->name('besoins.destroy');
Route::get('/', function (){return view('SDP.index');});

//! Sous directeur de personnel
// Expression des besoins
Route::get('session', [App\Http\Controllers\SessionController::class, 'index'])->name('session.index');
Route::resource('besoins', 'App\Http\Controllers\BesoinController');
// Les commissions
Route::get('commissions',function(){return view('SDP.commissions.index');});






Route::resource('criteres', 'App\Http\Controllers\GlobalcriteriasController');

