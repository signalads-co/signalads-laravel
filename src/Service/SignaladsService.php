<?php

namespace Signalads\Laravel\Service;

use SignalAds\SignalAdsApi;

class SignaladsService
{
    public SignalAdsApi $signalads;

    public function __construct()
    {
        $this->signalads = new SignalAdsApi(config('signalads.apikey'));
    }

    public function send(string $sender, string $receptor, string $text, $date = null)
    {
        return $this->signalads->send($sender, $receptor, $text, $date);
    }

    public function sendGroup(string $sender, array $receptor, string $text, $date = null)
    {
        return $this->signalads->SendGroup($sender, $receptor, $text, $date);
    }

    public function sendPair(string $sender, array $messages)
    {
        return $this->signalads->SendPair($sender, $messages);
    }

    public function sendPattern(string $sender, int $patternId, array $patternParams, array $receptors)
    {
        return $this->signalads->SendPattern($sender, $patternId, $patternParams, $receptors);
    }

    public function status(
        int    $messageId,
        int    $limit = null,
        int    $offset = null,
        int    $status = null,
        string $receptor = null
    )
    {
        return $this->signalads->Status($messageId, $limit, $offset, $status, $receptor);
    }

    public function getCredit()
    {
        return $this->signalads->GetCredit();
    }

    public function getPackagePrice()
    {
        return $this->signalads->GetPackagePrice();
    }
}
