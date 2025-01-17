<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use App\Models\User;

class PostDeletedNotification extends Notification
{
    use Queueable;

    protected $post;
    protected $admin;
    protected $reason;

    public function __construct(Post $post, User $admin, string $reason)
    {
        $this->post = $post;
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
            'message' => "Your post '{$this->post->title}' was deleted by admin {$this->admin->name}",
            'reason' => $this->reason,
            'admin_id' => $this->admin->id,
            'post_title' => $this->post->title
        ];
    }
}