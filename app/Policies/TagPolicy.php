<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;

class TagPolicy
{
    public function update(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }

    public function destroy(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }
}
