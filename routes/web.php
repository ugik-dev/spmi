<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\IndikatorController;
use App\Http\Controllers\ElementController;

Route::redirect('/', '/login');

// Authenticated User Routes
Route::middleware('auth')->group(function () {

  // Dashboard
  Route::get('/dasbor', [DashboardController::class, 'index'])->name('dashboard');

  // User Routes
  Route::prefix('pengguna')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->middleware('can:see users')->name('index');
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

  // StudyProgram Routes
  Route::prefix('prodi')->name('programs.')->group(function () {
    Route::get('/', [StudyProgramController::class, 'index'])->middleware('can:see prodis')->name('index');
    Route::post('/tambah', [StudyProgramController::class, 'create'])->middleware('can:create prodi')->name('create');
    Route::patch('/edit/{study_program}', [StudyProgramController::class, 'edit'])->middleware('can:edit prodi')->name('edit');
    Route::delete('/hapus/{study_program}', [StudyProgramController::class, 'delete'])->middleware('can:delete prodi')->name('delete');
  });

  // Criterion Routes
  Route::prefix('kriteria')->name('criteria.')->group(function () {
    Route::get('/', [CriterionController::class, 'index'])->middleware('can:see criteria')->name('index');
    Route::post('/tambah', [CriterionController::class, 'create'])->middleware('can:create criterion')->name('create');

    // Route::patch('/edit/{study_program}', [StudyProgramController::class, 'edit'])->middleware('can:edit prodi')->name('edit');
    // Route::delete('/hapus/{study_program}', [StudyProgramController::class, 'delete'])->middleware('can:delete prodi')->name('delete');
  });

  Route::get('/get-parent-criteria', [CriterionController::class, 'getParentCriteria'])->name('get-parent-criteria');

  Route::prefix('kriterias')->name('kriteria.')->group(function () {
    Route::get('/', [KriteriaController::class, 'index'])->middleware('can:see kriteria')->name('index');
    Route::post('/create', [KriteriaController::class, 'create'])->middleware('can:create kriteria')->name('create');
    Route::patch('/edit', [KriteriaController::class, 'edit'])->middleware('can:edit kriteria')->name('edit');
    Route::delete('/hapus', [KriteriaController::class, 'delete'])->middleware('can:delete kriteria')->name('delete');
    Route::get('/search', [KriteriaController::class, 'search'])->middleware('can:see search kriteria')->name('search');
  });

  Route::prefix('indikator')->name('indikator.')->group(function () {
    Route::get('/', [IndikatorController::class, 'index'])->middleware('can:see indikator')->name('index');
    Route::post('/create', [IndikatorController::class, 'create'])->middleware('can:create indikator')->name('create');
    Route::get('/edit/{indikator}', [IndikatorController::class, 'form_edit'])->middleware('can:edit indikator')->name('edit');
    Route::put('/put/{indikator}', [IndikatorController::class, 'edit'])->middleware('can:edit indikator')->name('put');
    Route::delete('/hapus', [IndikatorController::class, 'delete'])->middleware('can:delete indikator')->name('delete');
    Route::get('/search', [IndikatorController::class, 'search'])->middleware('can:see search indikator')->name('search');
  });

  Route::prefix('element')->name('element.')->group(function () {
    Route::get('/', [ElementController::class, 'index'])->middleware('can:see element')->name('index');
    Route::post('/sync', [ElementController::class, 'sync'])->middleware('can:see sync element')->name('sync');
  });

  Route::get('search-select-lam', [KriteriaController::class, 'search_select']);
});

Auth::routes();
