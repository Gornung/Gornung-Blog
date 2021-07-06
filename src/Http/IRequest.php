<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Http;

interface IRequest
{

    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @param  string  $url
     */
    public function setUrl(string $url): void;

    /**
     * @return array
     */
    public function getParameters(): array;

    /**
     * @param  string  $name
     *
     * @return string
     */
    public function getParameter(string $name): string;

    /**
     * @param  string  $name
     * @param  string  $parameter
     */
    public function setParameter(string $name, string $parameter): void;

    /**
     * @param  array  $parameters
     */
    public function setParameters(array $parameters): void;

    /**
     * @param  string  $name
     *
     * @return bool
     */
    public function hasParameter(string $name): bool;

    /**
     * @param  string  $string
     *
     * @return string
     */
    public function getQueryParam(string $string): string;

    /**
     * @return string
     */
    public function getMethode(): string;

    /**
     * @param string $methode
     */
    public function setMethode(string $methode): void;

}
