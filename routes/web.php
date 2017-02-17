<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api/v1'], function () {
    Route::resource('lessons', 'LessonsController');
});
