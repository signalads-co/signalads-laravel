<?php

namespace Signalads\Laravel\Facade;

use Illuminate\Support\Facades\Facade;
use Signalads\Laravel\Service\SignaladsService;

/**
 * @method static sendGroup(string $sender, string[] $receptors, string $message)
 * @method static send(string $sender, string $receptor, string $message)
 * @method static sendPair(string $sender, string[] $receptors)
 * @method static sendPattern(string $sender, int $patternId, int[] $patternParams, string[] $receptors)
 * @method static status(int $messageId, int $limit, int $offset, int $status, string $receptor)
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
