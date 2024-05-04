<?php

use Illuminate\Support\Facades\Route;
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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/finger', [App\Http\Controllers\HomeController::class, 'finger'])->name('finger');

    Route::resource('fpUsers', App\Http\Controllers\FpUserController::class);
    Route::resource('fpAttendances', App\Http\Controllers\FpAttendanceController::class);
    Route::resource('fpIzins', App\Http\Controllers\FpIzinController::class);

    Route::get('attendancetest', [App\Http\Controllers\HomeController::class,'attendancetest']);
    Route::get('fpAttendances_sync', [App\Http\Controllers\FpAttendanceController::class,'fpAttendances_sync'])->name('fpAttendances.sync');
    Route::get('fpAttendances_sync_clear', [App\Http\Controllers\FpAttendanceController::class,'fpAttendances_sync_clear'])->name('fpAttendances.sync_clear');
    Route::get('fpUsers_sync', [App\Http\Controllers\FpUserController::class,'fpuser_sync'])->name('fpUsers.sync');
});
