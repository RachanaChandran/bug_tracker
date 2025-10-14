<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/login', [AdminController::class, 'index']);
Route::post('/login', [AdminController::class, 'login'])->name('login');
Route::get('add/issue', [AdminController::class, 'add'])->name('add.issue');
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/getdata', [AdminController::class, 'getData'])->name('dashboard.getdata');
Route::post('/create', [AdminController::class, 'create'])->name('create');
Route::get('/view/{id}', [AdminController::class, 'view'])->name('view');
Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [AdminController::class, 'update'])->name('update');

Route::get('/statuslog',[AdminController::class,'statusLog'])->name('statuslog');

Route::get('/comment/{id}',[AdminController::class,'comment'])->name('comment');

Route::get('/statuslog/getdata',[AdminController::class,'statusGetData'])->name('logs.getdata');
Route::delete('/delete/{id}',[AdminController::class,'delete']);
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
