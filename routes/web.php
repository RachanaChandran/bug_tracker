<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [AdminController::class, 'index']);
Route::post('/login', [AdminController::class, 'login'])->name('login');
Route::get('add/issue', [AdminController::class, 'add'])->name('add.issue');
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/getdata', [AdminController::class, 'getData'])->name('dashboard.getdata');
Route::post('/create', [AdminController::class, 'create'])->name('create');
Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
Route::post('/update', [AdminController::class, 'update'])->name('update');
