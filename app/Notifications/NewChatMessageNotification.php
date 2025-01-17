<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Message;
use App\Models\User;

class NewChatMessageNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $sender;

    public function __construct(Message $message, User $sender)
    {
        $this->message = $message;
        $this->sender = $sender;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "New message from {$this->sender->name}",
            'sender_id' => $this->sender->id,
            'message_preview' => \Str::limit($this->message->message, 50)
        ];
    }
}