<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;

class ThreadPolicy
{
    public function manage(User $user, Thread $thread): bool
    {
        return $user->canManageThread($thread);
    }
} 