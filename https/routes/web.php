<?php

Route::get('redis', function(){
    Redis::set('friend', 'momo');
    dd(Redis::get('friend'));
});

Route::get('/', 'FrontendController@welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logout', function () {
    auth()->logout();
});

Route::get("/register/confirm", 'ConfirmUserTokenController@index')
    ->name('confirm-email');

Route::middleware('admin')->prefix('admin')->group(function (){
    Route::resource('series', 'SeriesController');
    Route::resource('{series_by_id}/lessons', 'LessonController');
});
