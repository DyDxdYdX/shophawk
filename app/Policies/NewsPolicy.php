<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, News $news): bool
    {
        // Admin can view everything
        if ($user && $user->is_admin) {
            return true;
        }

        // Anyone can view published articles
        return $news->status === 'published';
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, News $news): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, News $news): bool
    {
        return $user->is_admin;
    }
} 