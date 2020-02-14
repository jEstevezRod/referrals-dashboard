<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class DomainCreated extends Notification
{
    use Queueable;

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->content('One of your invoices has been paid!');
    }
}
