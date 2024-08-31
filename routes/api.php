<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class)->except(['show', 'update', 'destroy']);
    Route::get('posts/{post}', [PostController::class, 'show'])->middleware('can:show,post');
    Route::patch('posts/{post}', [PostController::class, 'update'])->middleware('can:update,post');
    Route::patch('posts/{post}/restore', [PostController::class, 'restore'])->middleware('can:restore,post');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->middleware('can:destroy,post');

    Route::apiResource('tags', TagController::class)->except(['show', 'update', 'destroy']);
    Route::patch('tags/{tag}', [TagController::class, 'update'])->middleware('can:update,tag');
    Route::delete('tags/{tag}', [TagController::class, 'destroy'])->middleware('can:destroy,tag');

    Route::get('/stats', StatController::class);
});
