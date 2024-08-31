<?php

use App\Jobs\DeleteOldPosts;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

Artisan::command('posts:force-delete', function () {
    DeleteOldPosts::dispatch();
})->purpose('removing old delete posts')->daily();

Artisan::command('users:log', function () {
    $response = Http::get('https://randomuser.me/api/');
    Log::info($response->json()['results']);
})->purpose('log users every six hours')->everySixHours();
