<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::post('/login-data', [App\Http\Controllers\Auth\LoginController::class, 'sendLoginResponse'])->name('login-data');

Route::group(['middleware' => ['auth','isAdmin']], function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('index');
    Route::get('/verify-student/{id}', [App\Http\Controllers\AdminController::class, 'verifyStudent'])->name('verify-student');
    Route::get('/student/edit/{id}', [App\Http\Controllers\AdminController::class, 'editStudent'])->name('edit-student');
    Route::post('/student/update/{id}', [App\Http\Controllers\AdminController::class, 'updateStudent'])->name('update-student');
    Route::get('/export', [App\Http\Controllers\AdminController::class, 'export'])->name('export');
    Route::get('/import', [App\Http\Controllers\AdminController::class, 'importView'])->name('import');
    Route::post('/import-data', [App\Http\Controllers\AdminController::class, 'importData'])->name('import-data');
 
 });

 Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
 });