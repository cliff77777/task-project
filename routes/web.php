<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\VerificationController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.index');//AuthenticatesUsers.showLoginForm
Route::post('/login', [LoginController::class, 'login'])->name('login'); //AuthenticatesUsers.login
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth'); //AuthenticatesUsers.logout


Auth::routes(['verify' => true]);
Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/check-email/{email}', [RegisterController::class, 'checkEmail'])->name('checkEmail');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');


Route::get('/home', [HomeController::class, 'index'])->name('home');
