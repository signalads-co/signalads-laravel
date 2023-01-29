<?php

namespace Signalads\Laravel\Enum;

final class SignalSendMethods
{
    const send = 'send';
    const sendGroup = 'sendGroup';
    const sendPattern = 'sendPattern';

    const ALL = [
        self::send,
        self::sendGroup,
        self::sendPattern,
    ];
}
