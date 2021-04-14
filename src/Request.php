<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung;

use PhpParser\Node\Scalar\String_;

class Request{
    protected $url = '';
    protected $parameters;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param mixed $parameters
     */
    public function setParameters($parameters): void
    {
        $this->parameters = $parameters;
    }

    public function getQueryParam(string $param)
    {
        $p = $this->getParameters();
        return $p[$param];
    }
}
