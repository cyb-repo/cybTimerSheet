<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeSheetController;
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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    $controller_path = 'App\Http\Controllers';
    Route::get('/', $controller_path . '\pages\HomePage@index')->name('pages-home');
    //clients
    Route::get('clients-list',[ClientController::class,'index'])->name('clients.index');
    Route::post('client-list',[ClientController::class,'store'])->name('clients.store');
    Route::delete('client-list/{id}',[ClientController::class,'destroy'])->name('clients.destroy');
    Route::get('client-list/{id}/edit',[ClientController::class,'edit'])->name('clients.edit');
    Route::get('clients',[ClientController::class,'clients'])->name('clients.get');
    //tasks
    Route::get('tasks-list',[TaskController::class,'index'])->name('tasks.index');
    Route::post('task-list',[TaskController::class,'store'])->name('tasks.store');
    Route::get('tasks',[TaskController::class,'tasks'])->name('tasks.get');
    Route::delete('task-list/{id}',[TaskController::class,'destroy'])->name('tasks.destroy');
    Route::get('task-list/{id}/edit',[TaskController::class,'edit'])->name('tasks.edit');
    //time sheet
    Route::get('time-sheet',[TimeSheetController::class,'index'])->name('timesheet.index');
});
