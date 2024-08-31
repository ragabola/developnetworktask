<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeleteOldPosts implements ShouldQueue
{
    use Queueable;

    function handle(): void
    {
        Post::onlyTrashed()->where('deleted_at', '<', now()->subDays(30))->forceDelete();
    }
}
