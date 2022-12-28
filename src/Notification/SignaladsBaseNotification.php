<?php

namespace Signalads\Laravel\Notification;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Signalads\Laravel\Channel\SignaladsChannel;
use Signalads\Laravel\Message\SignaladsMessage;

class SignaladsBaseNotification extends Notification
{

    /**
     * Get the notification's delivery channel.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['signalads'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Signalads\Laravel\Message\SignaladsMessage
     */
    public function toSignalads($notifiable)
    {
        return new SignaladsMessage();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
