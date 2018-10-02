<?php


Auth::routes();
Route::resource('watson', 'WatsonCallController',['only'=>'index']);
Route::get('/', 'WatsonCallController@index')->name('index');
