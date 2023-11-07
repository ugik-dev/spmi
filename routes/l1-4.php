<?php

Route::get('kriteria/{jenjang}', 'KriteriaController@detail')->name('jenjang');
Route::get('kriteria/', 'KriteriaController@index')->name('kriteria');
Route::delete('kriteria/delete', 'KriteriaController@delete');
Route::put('kriteria/rubah', 'KriteriaController@rubah');
Route::post('kriteria/tambahbaru', 'KriteriaController@tambah');

Route::post('kriteria/store', 'KriteriaController@store');
Route::delete('kriteria/hapus/{l1}', 'KriteriaController@hapus');
Route::put('kriteria/put/{l1}', 'KriteriaController@put');

//C1.x
Route::get('sub-kriteria/l2/{jenjang}', 'Level2Controller@sort')->name('l2-jenjang');
Route::get('sub-kriteria/l2', 'Level2Controller@index')->name('level2');
Route::post('sub-kriteria/l2/post', 'Level2Controller@store');
Route::delete('sub-kriteria/l2/hapus/{l2}', 'Level2Controller@hapus');
Route::put('sub-kriteria/l2/put/{l2}', 'Level2Controller@put');

//C1.x.x
Route::get('sub-kriteria/l3/{jenjang}', 'Level3Controller@sort')->name('l3-jenjang');
Route::get('sub-kriteria/l3', 'Level3Controller@index')->name('level3');
Route::post('sub-kriteria/l3/post', 'Level3Controller@store');
Route::delete('sub-kriteria/l3/hapus/{l3}', 'Level3Controller@hapus');
Route::put('sub-kriteria/l3/put/{l3}', 'Level3Controller@put');

//C1.x.x
Route::get('sub-kriteria/l4/{jenjang}', 'Level4Controller@sort')->name('l4-jenjang');
Route::get('sub-kriteria/l4', 'Level4Controller@index')->name('level4');
Route::post('sub-kriteria/l4/post', 'Level4Controller@store');
Route::delete('sub-kriteria/l4/hapus/{l4}', 'Level4Controller@hapus');
Route::put('sub-kriteria/l4/put/{l4}', 'Level4Controller@put');
