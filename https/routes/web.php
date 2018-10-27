<?php

//Route::get('redis', function(){
// key:value string
//    Redis::set('friend', 'momo');
//    Redis::get('friend');

// key:value list
//    Redis::lpush('frameworks', ['vuejs', 'laravel']);
//    dd(Redis::lrange('frameworks', 0, -1));

// key:value set. store unique values
//    Redis::sadd('frontend', ['angular', 'test']);
//    dd(Redis::smembers('frontend'));
//});

Route::get('/', 'FrontendController@welcome');
Route::get('series/{series}', 'FrontendController@series')
    ->name('series');
Route::get('watch-series/{series}', 'WatchSeriesController@index')
    ->name('series.learning');
Route::get('series/{series}/lesson/{lesson}', 'WatchSeriesController@showLesson')
    ->name('series.watch');

Route::post('/series/complete-lesson/{lesson}', 'WatchSeriesController@completeLesson');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logout', function () {
    auth()->logout();
});

Route::get("/register/confirm", 'ConfirmUserTokenController@index')
    ->name('confirm-email');

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::resource('series', 'SeriesController');
    Route::resource('{series_by_id}/lessons', 'LessonController');
});
