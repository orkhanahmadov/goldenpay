<?php

namespace Orkhanahmadov\Goldenpay\Response;

abstract class Status
{
    /**
     * @var int
     */
    protected $code;
    /**
     * @var string
     */
    protected $message;

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
