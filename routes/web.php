<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CasillaController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\VotoController;
//use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Route::get('casilla', [CasillaController::class,'index'])->name('casilla.index');
//Route::get('casilla/{casilla}/edit', [CasillaController::class,'edit'])->name('casilla.edit');
Route::resource('casilla', CasillaController::class);
Route::resource('candidato', CandidatoController::class);

Route::resource('voto', VotoController::class);
/*
Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
*/
#--- Socialite facebook

Route::get('login',[LoginController::class, 'index'])->name('login');

Route::get('login/facebook', [LoginController::class, 'redirectToFacebookProvider'] );
Route::get('login/facebook/callback', [LoginController::class, 'handleProviderFacebookCallback']  );
Route::get('logout',[LoginController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::resource('voto', VotoController::class);
});

//Route::get('casilla/pdf', 'CasillaController@generatepdf');
Route::get('/casilla/pdf',[CasillaController::class,'generatepdf'])->name('casilla.pdf');