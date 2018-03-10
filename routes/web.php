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

Route::view('scan','scan');
Route::get('/threads','ThreadController@index')->name('threads');
Route::get('/threads/create','ThreadController@create');
Route::get('/threads/search','SearchController@show');
Route::get('/threads/{channel}','ThreadController@index');
Route::get('/threads/{channel}/{thread}','ThreadController@show');
Route::patch('/threads/{channel}/{thread}','ThreadController@update');
Route::patch('/threads/{channel}/{thread}','ThreadController@update')->name('thread.update');
Route::post('/locked-threads/{thread}','LockedThreadController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('/locked-threads/{thread}','LockedThreadController@destroy')->name('locked-threads.destroy')->middleware('admin');

Route::delete('/threads/{channel}/{thread}','ThreadController@destroy');
Route::post('/threads','ThreadController@store')->middleware('must-be-confirmed');
Route::get('/threads/{channel}/{thread}/replies','ReplyController@index');
Route::post('/threads/{channel}/{thread}/replies','ReplyController@store');
Route::patch('/replies/{reply}','ReplyController@update');
Route::delete('/replies/{reply}','ReplyController@destroy')->name('reply.destroy');

Route::post('/replies/{reply}/best','BestReplyController@store')->name('best-reply.store');
Route::post('/threads/{channel}/{thread}/subscriptions','ThreadSubscriptionController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions','ThreadSubscriptionController@destroy')->middleware('auth');

Route::post('/replies/{reply}/favorites','FavoriteController@store');
Route::delete('/replies/{reply}/favorites','FavoriteController@destroy');


Route::get('/profiles/{user}','ProfileController@show')->name('profile');
Route::get('/profiles/{user}/notifications','UserNotificationController@index');
Route::delete('/profiles/{user}/notifications/{notification}','UserNotificationController@destroy');

Route::get('/register/confirm','Auth\RegisterConfirmationController@index')->name('register.confirm');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/api/users','Api\UsersController@index');
Route::post('/api/users/{user}/avatar','Api\UserAvatarController@store')->name('avatar');
