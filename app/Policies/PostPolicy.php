<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function show(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function destroy(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function restore(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
