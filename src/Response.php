<?php

namespace Saidqb\CorePhp;

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

    public function response(): array
    {
        return [
            'body' => $this->body,
            'status' => $this->status
        ];
    }

    public function send(): void
    {
        http_response_code($this->status);
        echo $this->body;
    }
}

