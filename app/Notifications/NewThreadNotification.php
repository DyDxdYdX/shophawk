<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Thread;
use App\Models\User;

class NewThreadNotification extends Notification
{
    use Queueable;

    protected $thread;
    protected $sender;

    public function __construct(Thread $thread, User $sender)
    {
        $this->thread = $thread;
        $this->sender = $sender;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->sender->name} replied to your post '{$this->thread->post->title}'",
            'sender_id' => $this->sender->id,
            'post_id' => $this->thread->post_id,
            'thread_preview' => \Str::limit($this->thread->content, 50)
        ];
    }
} 