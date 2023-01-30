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

    public function send(string $receptor, string $text, string $sender = '', $date = null)
    {
        $sender = $this->getSender($sender);

        return $this->signalads->send($sender, $receptor, $text, $date);
    }

    public function sendGroup(array $receptor, string $text,  string $sender = '',$date = null)
    {
        $sender = $this->getSender($sender);

        return $this->signalads->SendGroup($sender, $receptor, $text, $date);
    }

    public function sendPair(array $messages, string $sender = '')
    {
        $sender = $this->getSender($sender);

        return $this->signalads->SendPair($sender, $messages);
    }

    public function sendPattern(int $patternId, array $patternParams, array $receptors, string $sender = '')
    {
        $sender = $this->getSender($sender);

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

    private function getSender(string $sender = '')
    {
        return empty($sender) ? config('signalads.sender') : $sender;
    }
}
