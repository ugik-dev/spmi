<?php

use Illuminate\Support\Facades\Route;

// Auth
Route::get('login', 'AuthController@index')->name('login');
Route::post('proses', 'AuthController@proses');
Route::post('logout', 'AuthController@logout')->name('logout');

Route::get('/', function () {
    return redirect()->route('login');
});
// Authenticated User With Checking Roles Middleware
Route::middleware(['auth'])->group(function () {

    // DASHBOARD
    $roles = ['admin', 'prodi', 'auditor'];

    foreach ($roles as $role) {
        Route::middleware(['cekRole:' . $role])->prefix($role)->name($role . '.')->group(function () {
            Route::get('/dashboard', 'Auth\DashboardController@index')->name('dashboard');
        });
    }
});
