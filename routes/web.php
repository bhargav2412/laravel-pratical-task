<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/post/create', 'PostController@create')->name('post.create');
Route::post('/post/store', 'PostController@store')->name('post.store');

Route::get('/posts', 'PostController@index')->name('posts');
Route::get('/post/show/{id}', 'PostController@show')->name('post.show');

Route::get('/post/edit/{id}', 'PostController@edit')->name('post.edit');
Route::post('/post/update/{id}', 'PostController@update');

Route::post('/comment/store', 'CommentController@store')->name('comment.add');
Route::post('/reply/store', 'CommentController@replyStore')->name('reply.add');
Route::get('/comment/delete/{id}', 'CommentController@commentDelete');
