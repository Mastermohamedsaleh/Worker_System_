<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminPost extends Notification
{
    use Queueable;

    protected $worker , $post ; 

    public function __construct($worker , $post)
    {
        $this->worker = $worker ; 
        $this->post = $post ; 
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    
    public function toArray($notifiable)
    {
        return [
            'worker' => $this->worker,
            'post' => $this->post,
        ];
    }
}
