<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/test', function (Request $request) {
    return [1,2,3];
});
Route::controller(UserController::class)->group(function () {
    Route::post('/registration', 'registration');
    Route::post('/auth', 'auth');
    Route::post('/check-user', 'checkUser');
    Route::post('/post-loader-avatar', 'postLoaderAvatar');
    Route::post('/post-faile-users', 'postFaileUsers');
    Route::post('/post-faile-blockedUser/{userId}', 'postFaileBlockedUser');
    Route::post('/post-faile-activeUser/{userId}', 'postFaileActiveUser');
});
Route::controller(IndexController::class)->group(function () {
    Route::get('/get-faile-news', 'getFaileNews');
    Route::get('/get-faile-newsChild/{newsId}', 'getFaileNewsChild');
    Route::post('/like-plus/{newsId}', 'likePlus');
    Route::get('/faile-news-autor/{AuthorId}', 'faileNewsAutor');
    Route::post('/post-loader-news', 'postLoaderNews');
    Route::post('/post-loader-images', 'postLoaderImages');
    Route::post('/post-delete-news/{newsIds}', 'postDeleteNews');
    Route::get('/get-faile-news-like', 'getFaileNewsLike');
    Route::post('/post-redact-news', 'postRedactNews');
    Route::post('/get-views-plus/{newsId}', 'getViewsPlus');
    Route::get('/get-faile-active-news', 'getFaileActivNews');
    Route::get('/get-faile-blockedNews/{newsId}', 'getFaileBlockedNews');
    Route::get('/get-faile-activeNews/{newsId}', 'getFaileActiveNews');
    Route::get('/mail', 'mail');
});