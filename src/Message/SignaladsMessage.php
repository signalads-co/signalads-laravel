<?php

namespace Signalads\Laravel\Message;


use Signalads\Laravel\Enum\SignalSendMethods;

class SignaladsMessage
{
    /**
     * The message content.
     */
    public string $content;

    /**
     * pattern parameters
     */
    public int $patternId;
    public array $patternParams;

    /**
     * The phone number the message should be sent from.
     */
    public string $from;

    /**
     * The phone number the message should be received to.
     */
    public string|array $to;


    /**
     * The message type.
     */
    public string $type = 'text';

    /**
     * the send method, selected from SignalSendMethods.
     */
    public string $method;

    /**
     * Create a new message instance.
     *
     * @param string $content
     * @return void
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * Set the phone number the message should be sent from.
     *
     * @param string $from
     * @return $this
     */
    public function from(string $from): static
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the phone number the message should be received to.
     *
     * @param string|array $to
     * @return $this
     */
    public function to(string|array $to): static
    {
        $this->to = $to;

        return $this;
    }

    /**
     * set active and verify pattern id
     *
     * @param int $patternId
     * @return $this
     */
    public function patternId(int $patternId): static
    {
        $this->patternId = $patternId;

        return $this;
    }

    /**
     * set active and verify pattern params
     *
     * @param array $params
     * @return $this
     */
    public function patternParams(array $params): static
    {
        $this->patternParams = $params;

        return $this;
    }


    /**
     * Set send method by default set send.
     *
     * @param string $sendMethod
     * @return $this
     */
    public function sendMethod(string $sendMethod = SignalSendMethods::send): static
    {
        $this->method = $sendMethod;
        return $this;
    }

}
