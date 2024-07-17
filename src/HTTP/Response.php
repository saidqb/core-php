<?php

namespace Saidqb\CorePhp\HTTP;

use Saidqb\CorePhp\Utils\ResponseCodeInterface;

class Response implements ResponseCodeInterface
{
    private $body;
    private $status;

    public function __construct(string $body, int $status)
    {
        $this->body = $body;
        $this->status = $status;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}

