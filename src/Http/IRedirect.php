<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Http;

interface IRedirect
{

    public function execute(): void;

    /**
     * @param  string  $route
     */
    public function redirect(string $route): void;
}
