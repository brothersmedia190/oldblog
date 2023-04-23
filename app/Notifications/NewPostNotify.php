<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPostNotify extends Notification
{
    use Queueable;
    public $post;
 
    public function __construct($post)
    {
        $this->post = $post;
    }
 
    public function via($notifiable)
    {
        return ['mail'];
    }
 
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Post Available')
            ->greeting('Hello, Subscriber')
            ->line('There is a new post. We hope you will like it.')
            ->line('Post Title : '.$this->post->title)
            ->action('View Post', url('/'))
            ->line('Thank you for using our application!');
    }
 
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
