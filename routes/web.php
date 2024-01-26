<?php

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

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TicketsController;
use Illuminate\Support\Facades\Route;

Route::get('/add', [TicketsController::class, 'showAddForm'])->name('showTicket');
Route::post('/add', [TicketsController::class , 'addTicket']);
Route::get('/start', [TicketsController::class , 'start']);
Route::get('/launch', [TicketsController::class , 'launch']);
Route::get('/results', [TicketsController::class , 'results']);

Route::get('/install', [AdminController::class , 'install']);
Route::get('/add-test-case', [AdminController::class , 'addTestCase']);

