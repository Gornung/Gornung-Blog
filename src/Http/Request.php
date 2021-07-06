<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Http;

class Request implements IRequest
{

    /**
     * @var string
     */
    protected string $url = '';

    /**
     * @var string
     */
    protected string $methode = '';

    /**
     * @var array
     */
    protected array $parameters;


    /**
     * Request constructor.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @param  string  $methode
     */
    public function __construct(
        string $url,
        array $parameters,
        string $methode = 'GET'
    ) {
        $this->url = $url;
        $this->parameters = $parameters;
        $this->methode = $methode;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param  mixed  $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @param  string  $name
     *
     * @return string
     */
    public function getParameter(string $name): string
    {
        return $this->parameters[$name];
    }

    /**
     * @param  string  $name
     * @param  string  $parameter
     */
    public function setParameter(string $name, string $parameter): void
    {
        $this->parameters[$name] = $parameter;
    }

    /**
     * @param  string  $name
     *
     * @return bool
     */
    public function hasParameter(string $name): bool
    {
        return isset($this->parameters[$name]);
    }

    /**
     * @param  string  $param
     *
     * @return string
     */
    public function getQueryParam(string $param): string
    {
        $p = $this->getParameters();
        return $p[$param];
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param  array  $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    public function getMethode(): string
    {
        return $this->methode;
    }

    public function setMethode(string $methode): void
    {
        $this->methode = $methode;
    }
}
