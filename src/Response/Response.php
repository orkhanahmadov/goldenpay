<?php

namespace Orkhanahmadov\Goldenpay\Response;

abstract class Response
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
     * Response constructor.
     *
     * @param int    $code
     * @param string $message
     */
    public function __construct(int $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

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
