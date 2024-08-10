<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskFileController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\TaskFlowController;
use App\Http\Controllers\UserRoleController;


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
Auth::routes(['verify' => true]);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/',[HomeController::class, 'index'])->name('home.index');
Route::get('/home', [HomeController::class, 'index'])->name('home');

//login logout 
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.index');//AuthenticatesUsers.showLoginForm
Route::post('/login', [LoginController::class, 'login'])->name('login'); //AuthenticatesUsers.login
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth'); //AuthenticatesUsers.logout

//user register
Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

//emial
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::middleware(['auth'])->group(function () {
    //task controller
    Route::resource('tasks', TaskController::class);
    Route::post('task_cancel', [TaskController::class,'task_cancel'])->name('task_cancel');

    //file controller
    Route::post('download_file/{file_path}', [FilesController::class, 'download_file'])->where('file_path', '.*') ->name('download_file');
    Route::delete('delete_file/{file_path}', [FilesController::class, 'delete_file'])->where('file_path', '.*') ->name('delete_file');
    Route::post('upload_file/{file_path}', [FilesController::class, 'upload_file'])->where('file_path', '.*') ->name('upload_file');

    //activity controller
    Route::get('activity_log', [ActivityLogController::class,'index'])->name('activity_log.index');

    //work flow
    Route::resource('task_flow',TaskFlowController::class);

    //user role
    Route::resource('user_role',UserRoleController::class);

    



});
