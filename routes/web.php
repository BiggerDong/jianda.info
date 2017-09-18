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



Auth::routes();

Route::get('/', 'QuestionsController@index')->name('home');

Route::get('/captcha/{config?}',function (\Mews\Captcha\Captcha $captcha, $config = 'default') {
    return $captcha->create($config);
});

Route::get('/verify/mail/{token}','VerifyMailsController@verify')->name('verifymail');

Route::get('/auth/weibo','Auth\LoginController@weibo');
Route::get('/weibo/callback','Auth\LoginController@weiboCallback');

Route::get('/auth/qq','Auth\LoginController@qq');
Route::get('/qq/callback','Auth\LoginController@qqCallback');

Route::get('/auth/github','Auth\LoginController@github');
Route::get('/github/callback','Auth\LoginController@githubCallback');

Route::resource('/questions','QuestionsController');
Route::get('/questions/{question}','QuestionsController@show')->name('questionshow');

Route::post('/questions/{question}/answer','AnswersController@store');

Route::get('/topics','TopicsController@index');
Route::get('/topics/{id}','TopicsController@show');

Route::get('/notifications/read','NotificationsController@read');
Route::get('/notifications','NotificationsController@index');
Route::get('/notifications/{notification}','NotificationsController@show');

Route::get('/users/{id}/home','UsersController@home')->name('userhome');
Route::get('/users/{id}/answers','UsersController@answers');
Route::get('/users/{id}/followq','UsersController@followq');
Route::get('/users/{id}/followt','UsersController@followt');
Route::get('/users/{id}/following','UsersController@following');
Route::get('/users/{id}/follower','UsersController@follower');
Route::get('/users/profile','UsersController@edit');
Route::post('/users/profile','UsersController@store');
Route::post('avatar','UsersController@changeAvatar');

Route::get('/search','QuestionsController@search');

Route::get('/about','InfosController@about');
Route::get('/help','InfosController@help');