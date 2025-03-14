<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/signup','signup');
    Route::post('/signin', 'signin');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/signout', 'signout');
    });
});

Route::controller(ProfileController::class)->group(function () {
   Route::middleware('auth:sanctum')->group(function () {
       Route::get('/profile', 'show');
       Route::post('/profile', 'update');
       Route::post('/profile/password', 'updatePassword');
   });
});

Route::controller(PostController::class)->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/post', 'index');
        Route::post('/post', 'store');
        Route::post('/post/{post}/update', 'update');
        Route::post('/post/{post}/delete', 'delete');
    });
});

Route::controller(LikeController::class)->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/like/{post}/like', 'like');
        Route::post('/like/{post}/unlike', 'unlike');
    });
});

Route::controller(CommentController::class)->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/comment/{post}', 'index');
        Route::post('/comment/{post}', 'store');
        Route::post('/comment/{post}/update', 'update');
        Route::post('/comment/{post}/delete', 'delete');
    });
});

Route::controller(FollowController::class)->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/follow/{user}/follow', 'follow');
        Route::post('/follow/{user}/unfollow', 'unfollow');
    });
});
