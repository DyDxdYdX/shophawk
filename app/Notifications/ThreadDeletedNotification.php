<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Thread;
use App\Models\User;

class ThreadDeletedNotification extends Notification
{
    use Queueable;

    protected $thread;
    protected $admin;
    protected $reason;

    public function __construct(Thread $thread, User $admin, string $reason)
    {
        $this->thread = $thread;
        $this->admin = $admin;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Your thread in post '{$this->thread->post->title}' was deleted by admin {$this->admin->name}",
            'reason' => $this->reason,
            'admin_id' => $this->admin->id,
            'post_title' => $this->thread->post->title
        ];
    }
} 