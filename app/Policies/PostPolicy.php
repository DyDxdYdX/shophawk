<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Post $post)
    {
        return $user->isAdmin() || $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post)
    {
        return $user->isAdmin() || $user->id === $post->user_id;
    }

    public function manage(User $user): bool
    {
        return $user->isAdmin();
    }
} 