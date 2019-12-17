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

Route::post('/commentStore' , 'FrontEnd\CommentController@storePost');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/profile/{name}', 'HomeController@profile')->name('profile');
    Route::get('/myProfile/{id}' , "HomeController@myProfile");
    Route::get('/loadNotification' , 'HomeController@loadUnReadNotification');
    Route::get('/explorer' , 'FrontEnd\PostController@explorer');
    Route::get('/callModal', 'HomeController@callModal');
    Route::post('/fetchPost' , 'FrontEnd\PostController@fetchPost');
    Route::post('/follow' , 'FrontEnd\FollowsController@store') ;
    Route::get('markAsRead' , 'FrontEnd\PostController@readNotification')->name('markRead');
    Route::get('/unReadNotification' , 'FrontEnd\PostController@unReadNotification');
    Route::get('/download' , 'FrontEnd\ExportController@exportData');
    Route::get('/downloadNotificationData', 'FrontEnd\ExportController@exportNotificationData');
    Route::get('/storeNoticationData' , 'FrontEnd\ExportController@storeNotificationData');
    Route::get('/storeExel' , 'FrontEnd\ExportController@storeData');
    Route::get('/readNotification' , 'FrontEnd\PostController@notifactionRead');
    Route::post('/unfollow' , 'FrontEnd\FollowsController@unFollow');
    Route::post('/accept/{id}' , 'FrontEnd\FollowsController@accept');
    Route::get('/search' , 'HomeController@search');
    Route::get('/post/{id}', 'FrontEnd\PostController@postModal');
    Route::get('/fetchComment/{id}', 'FrontEnd\CommentController@fetchComment');
    Route::post('/replayComment', 'FrontEnd\CommentController@replayComment');
    Route::post('/likePost', 'FrontEnd\PostController@like');
    Route::get('/replayedComment/{id}', 'FrontEnd\CommentController@replayedComment');
    Route::get('/createPost' , 'FrontEnd\PostController@createPost');
    Route::resource('profile', 'FrontEnd\ProfileController');

    Route::resource('post', 'FrontEnd\PostController');
    Route::resource('export' , 'FrontEnd\ExportController');
    Route::resource('comment', 'FrontEnd\CommentController');
});
