<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function __invoke()
    {
        $results = cache()->rememberForever('stats', function () {
            return [
                'total_users' => User::count(),
                'total_posts' => Post::count(),
                'total_users_with_no_posts' => User::doesntHave('posts')->count(),
            ];
        });
        return response()->json($results);
    }
}
