<?php

namespace Signalads\Laravel\Channel;

use Signalads\SignaladsApi;
use Signalads\Laravel\Message\SignaladsMessage;
use \Signalads\Laravel\Facade as Signalads;

class SignaladsChannel
{
    /**
     * The Signalads client instance.
     *
     * @var Signalads\SignaladsApi
     */
    protected $signalads;

    /**
     * The phone number notifications should be sent from.
     *
     * @var string
     */
    protected $from;

    /**
     * Create a new Signalads channel instance.
     *
     * @param Signalads\SignaladsApi $signalads
     * @param string $from
     * @return void
     */
    public function __construct(SignaladsApi $signalads, $from = null)
    {
        $this->from = $from;
        $this->signalads = $signalads;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return \Signalads\Laravel\Message\SignaladsMessage
     */
    public function send($notifiable, $notification)
    {
        $message = $notification->toSignalads($notifiable);

        $message->to($message->to ?: $notifiable->routeNotificationFor('signalads', $notification));
        if (!$message->to || !($message->from || $message->method)) {
            return;
        }

        return $message->method ?
            $this->verifyLookup($message) :
            Signalads::Send($message->from, $message->to, $message->content);
    }

    public function verifyLookup(SignaladsMessage $message)
    {
        $token2 = isset($message->tokens[1]) ? $message->tokens[1] : null;
        $token3 = isset($message->tokens[2]) ? $message->tokens[2] : null;
        return Signalads::VerifyLookup($message->to, $message->tokens[0], $token2, $token3, $message->method);
    }
}
