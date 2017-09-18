<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/topics', function (Request $request) {
    $data = \App\Topic::select(['id','name'])->where('name','like','%'.$request->query('search').'%')->get();
    return $data;
});

Route::middleware('auth:api')->post('/question/isfollowed', 'QuestionFollowController@isFollowed');
Route::middleware('auth:api')->post('/question/follow', 'QuestionFollowController@followThisQuestion');

Route::post('answer/{id}/votes/users','VotesController@users');
Route::post('answer/vote','VotesController@vote');

Route::get('answer/{id}/comments','CommentsController@answer');
Route::post('comment','CommentsController@store');

Route::put('questions/{id}/warning','QuestionsController@warning');

Route::post('/topic/isfollowed', 'TopicFollowController@isFollowed');
Route::post('/topic/follow', 'TopicFollowController@followThisTopic');

Route::post('/user/isfollowed', 'UserFollowController@isFollowed');
Route::post('/user/follow', 'UserFollowController@followThisUser');