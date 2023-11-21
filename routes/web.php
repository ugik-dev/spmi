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
  Route::get('/dasbor', 'Auth\DashboardController@index')->name('dashboard');

  Route::middleware(['can:see users'])->group(function () {
    Route::get('/pengguna', 'UserController@index')->name('users.index');
  });

  Route::patch('/edit-pengguna/{user}', 'UserController@edit')->middleware('can:edit user')->name('users.edit');
  Route::delete('/hapus-pengguna/{user}', 'UserController@delete')->middleware('can:delete user')->name('users.delete');
  Route::get('detail-pengguna/{user}', 'UserController@detail')->middleware('can:see user')->name('users.detail');
  Route::post('/tambah-pengguna', 'UserController@create')->middleware('can:create user')->name('users.create');
});
