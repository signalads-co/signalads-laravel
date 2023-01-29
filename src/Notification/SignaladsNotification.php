<?php

namespace Signalads\Laravel\Notification;

use Signalads\Laravel\Channel\SignaladsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Signalads\Laravel\Message\SignaladsMessage;

class SignaladsNotification extends Notification
{
    use Queueable;

    private string $message;
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SignaladsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return SignaladsMessage
     */
    public function toSignalads(mixed $notifiable): SignaladsMessage
    {
        return new SignaladsMessage('');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            'from' => 'to-array',
            'receptor' => $notifiable->receptor,
            'message' => $this->message
        ];
    }
}
