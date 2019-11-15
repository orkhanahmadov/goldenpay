<?php

namespace Orkhanahmadov\Goldenpay\Response;

abstract class Response
{
    /**
     * @var int|null
     */
    protected $code = null;
    /**
     * @var string|null
     */
    protected $message = null;

    /**
     * Response constructor.
     *
     * @param int|null    $code
     * @param string|null $message
     */
    public function __construct(?int $code, ?string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
}
