<?php

namespace Signalads\Laravel\Channel;


use Illuminate\Notifications\Notification;
use Signalads\Laravel\Enum\SignalSendMethods;
use Signalads\Laravel\Facade\Signalads;
use Signalads\Laravel\Service\SignaladsService;

class SignaladsChannel
{
    /**
     * @throws \Exception
     */
    public function send($notifiable, Notification $notification)
    {
        if (method_exists($notifiable, 'routeNotificationForSignalads')) {
            $receptor = $notifiable->routeNotificationForSignalads($notifiable);
        } else {
            $receptor = $notifiable->getKey();
        }

        $data = method_exists($notification, 'toSignalads')
            ? $notification->toSignalads($notifiable)
            : $notification->toArray($notifiable);
        if (empty($data)) {
            return;
        }


        $method = $data->method;

        if (
            $method == SignalSendMethods::sendGroup || SignalSendMethods::sendPattern
        ) {
            $receptor = is_array($receptor) ? $receptor : [$receptor];
        }

        if (method_exists(SignaladsService::class, $method)) {
            if (
                $method == SignalSendMethods::sendPattern
                && (!isset($data->patternParams) || !isset($data->patternId))
            ) {
                throw new \Exception('send method require pattern param and pattern id');
            } elseif (
                $method == SignalSendMethods::sendPattern
                && (isset($data->patternParams) || isset($data->patternId))
            ) {
                Signalads::$method(
                    config('signalads.sender'),
                    $data->patternId,
                    $data->patternParams,
                    $receptor
                );
                return true;
            }

            Signalads::$method(config('signalads.sender'), $receptor, $data->content);
        } else {
            Signalads::send(config('signalads.sender'), $receptor, $data->content);
        }

        return true;
    }
}
