<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\FacultyController;

// Auth Routes
// Route::get('login', [AuthController::class, 'index'])->name('login');
// Route::post('proses', [AuthController::class, 'proses']);
// Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::redirect('/', '/login');

// Authenticated User Routes
Route::middleware('auth')->group(function () {

  // Dashboard
  Route::get('/dasbor', [DashboardController::class, 'index'])->name('dashboard');

  // User Routes
  Route::prefix('pengguna')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->middleware('can:see users')->name('index');
    Route::get('/datatables', [UserController::class, 'datatables'])->middleware('can:see users')->name('datatables');
    Route::patch('/edit/{user}', [UserController::class, 'edit'])->middleware('can:edit user')->name('edit');
    Route::delete('/hapus/{user}', [UserController::class, 'delete'])->middleware('can:delete user')->name('delete');
    Route::post('/tambah', [UserController::class, 'create'])->middleware('can:create user')->name('create');
  });

  // Degree Routes
  Route::prefix('jenjang')->name('degrees.')->group(function () {
    Route::get('/', [DegreeController::class, 'index'])->middleware('can:see degrees')->name('index');
    Route::patch('/edit/{degree}', [DegreeController::class, 'edit'])->middleware('can:edit degree')->name('edit');
    Route::delete('/hapus/{degree}', [DegreeController::class, 'delete'])->middleware('can:delete degree')->name('delete');
    Route::post('/tambah', [DegreeController::class, 'create'])->middleware('can:create degree')->name('create');
  });

  // Faculty Routes
  Route::prefix('fakultas')->name('faculties.')->group(function () {
    Route::get('/', [FacultyController::class, 'index'])->middleware('can:see faculties')->name('index');
    Route::post('/tambah', [FacultyController::class, 'create'])->middleware('can:create faculty')->name('create');
    Route::patch('/edit/{faculty}', [FacultyController::class, 'edit'])->middleware('can:edit faculty')->name('edit');
    Route::delete('/hapus/{faculty}', [FacultyController::class, 'delete'])->middleware('can:delete faculty')->name('delete');
  });
});

Auth::routes();
