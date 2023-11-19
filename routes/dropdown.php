<?php

Route::post('dropdownlist/getJen', 'dropdownController@getJen')->name('getJen');
Route::post('dropdownlist/getPro', 'dropdownController@getPro')->name('getPro');
Route::post('dropdownlist/getIndikator', 'dropdownController@getIndikator')->name('getInd');
Route::post('dropdownlist/searchIndikator', 'dropdownController@searchIndikator')->name('searchIndikator');
Route::post('dropdownlist/getScore', 'dropdownController@getScore')->name('getScore');
Route::post('dropdownlist/getl1', 'dropdownController@getL1')->name('l1');
Route::post('dropdownlist/getl2', 'dropdownController@getL2')->name('l2');
Route::post('dropdownlist/getl3', 'dropdownController@getL3')->name('l3');
Route::post('dropdownlist/getl4', 'dropdownController@getL4')->name('l4');
Route::post('dropdownlist/getl4', 'dropdownController@getL4')->name('l4');

Route::get('search-select-lam', 'dropdownController@getKriteriaLam');


//NO MULTIPLE SAAT EDIT BERKAS
Route::post('dropdownlist/getl1ne', 'dropdownController@getL1ne')->name('l1ne');
Route::post('dropdownlist/getl2ne', 'dropdownController@getL2ne')->name('l2ne');
Route::post('dropdownlist/getl3ne', 'dropdownController@getL3ne')->name('l3ne');
Route::post('dropdownlist/getl4ne', 'dropdownController@getL4ne')->name('l4ne');

//NO MULTIPLE [Sub Butir L2 - L3]
Route::post('dropdownlist/getjn', 'dropdownController@getjn')->name('jn');
Route::post('dropdownlist/getl1n', 'dropdownController@getL1n')->name('l1n');
Route::post('dropdownlist/getl2n', 'dropdownController@getL2n')->name('l2n');
Route::post('dropdownlist/getl3n', 'dropdownController@getL3n')->name('l3n');
Route::post('dropdownlist/getl4n', 'dropdownController@getL4n')->name('l4n');

//NO MULTIPLE SAAT EDIT LEVEL [Sub Butir L2 - L4]
Route::post('dropdownlist/getjnu', 'dropdownController@getjnu')->name('jnu');
Route::post('dropdownlist/getl1nu', 'dropdownController@getL1nu')->name('l1nu');
Route::post('dropdownlist/getl2nu', 'dropdownController@getL2nu')->name('l2nu');
Route::post('dropdownlist/getl3nu', 'dropdownController@getL3nu')->name('l3nu');
Route::post('dropdownlist/getl4nu', 'dropdownController@getL4nu')->name('l4nu');
