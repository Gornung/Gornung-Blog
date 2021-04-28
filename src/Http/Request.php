<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Http;

class Request implements IRequest
{

    protected string $url = '';

    protected array $parameters;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    public function getParameter(string $name): string
    {
        return $this->parameters[$name];
    }

    public function setParameter(string $name, string $parameter): void
    {
        $this->parameters[$name] = $parameter;
    }

    public function hasParameter(string $name): bool
    {
        return isset($this->parameters[$name]);
    }
}
