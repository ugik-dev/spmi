<?php

Route::get('kriteria-lam', 'KriteriaController@index_lam')->name('kriterialam');
Route::get('kriteria-lam/getData/', 'KriteriaController@getData');
Route::post('kriteria-lam/tambahbaru', 'KriteriaController@store_lam');
Route::put('kriteria-lam/put', 'KriteriaController@edit_lam');
Route::delete('kriteria-lam/delete', 'KriteriaController@delete_lam');
Route::get('search-kriteria-lam', 'KriteriaController@searchLam');
