<?php

namespace Signalads\Laravel\Facade;

use Illuminate\Support\Facades\Facade;
use Signalads\Laravel\Service\SignaladsService;

/**
 * @method static sendGroup(string[] $receptors, string $message, string $sender = '')
 * @method static send(string $receptor, string $message, string $sender = '')
 * @method static sendPair(string[] $receptors, string $sender = '')
 * @method static sendPattern(int $patternId, int[] $patternParams, string[] $receptors, string $sender = '')
 * @method static status(int $messageId, int $limit = 5000, int $offset = 0, int $status = '', string $receptor = '')
 * @method static getCredit()
 * @method static getPackagePrice()
 *
 * @see SignaladsService
 */
class Signalads extends Facade
{
    // signalads php sdk object
    public $signalads;

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return static::class;
    }

    static function shouldProxyTo($class)
    {
        app()->singleton(self::getFacadeAccessor(), $class);
    }
}
