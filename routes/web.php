<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.template.instagram');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/profile/{name}', 'HomeController@profile')->name('profile');
    Route::get('/post/{id}', 'FrontEnd\PostController@postModal');
    Route::get('/fetchComment/{id}', 'FrontEnd\CommentController@fetchComment');
    Route::post('/replayComment', 'FrontEnd\CommentController@replayComment');
    Route::post('/like', 'FrontEnd\PostController@like')->route('like.post');
    Route::get('/replayedComment/{id}', 'FrontEnd\CommentController@replayedComment');
    Route::resource('profile', 'FrontEnd\ProfileController');

    Route::resource('post', 'FrontEnd\PostController');
    Route::resource('comment', 'FrontEnd\CommentController');
});
