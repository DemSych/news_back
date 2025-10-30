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
});
Route::controller(IndexController::class)->group(function () {
    Route::get('/get-faile-news', 'getFaileNews');
    Route::get('/get-faile-newsChild/{newsId}', 'getFaileNewsChild');
    Route::post('/like-plus/{newsId}', 'likePlus');
    Route::get('/faile-news-autor/{AuthorId}', 'faileNewsAutor');
    Route::post('/post-loader-news', 'postLoaderNews');
    Route::post('/post-loader-images', 'postLoaderImages');
});