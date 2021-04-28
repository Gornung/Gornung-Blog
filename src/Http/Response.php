<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Http;

class Response implements IResponse
{

    protected string $body;

    protected int $statusCode = 200;

    protected array $headers;

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function getHeader(string $name): string
    {
        return $this->headers[$name];
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeader(string $name, string $header): void
    {
        $this->headers[$name] = $header;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function hasHeader(string $name): bool
    {
        return isset($this->headers[$name]);
    }
}
