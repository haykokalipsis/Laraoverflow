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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions', 'QuestionController')->except(['show']);
Route::resource('questions.answers', 'AnswerController')->only(['store', 'edit', 'update', 'destroy']);
Route::post('/answers/{answer}/accept', 'AnswerController@acceptBestAnswer')->name('answers.accept');
//Route::post('/questions/{question}/answers', 'AnswerController@store')
Route::get('/questions/{slug}', 'QuestionController@show')->name('questions.show');

Route::post('/questions/{question}/favourites', 'FavouriteController@store')->name('questions.favourite');
Route::delete('/questions/{question}/favourites', 'FavouriteController@destroy')->name('questions.unfavourite');
