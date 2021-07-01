<?php

namespace Gornung\Webentwicklung;

use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;

// IRouter won't compile
interface RouterInterface
{

    /**
     * @param  string  $route
     * @param  string  $controllerName
     * @param  string  $actionName
     */
    public function addRoute(
        string $route,
        string $controllerName,
        string $actionName
    ): void;

    /**
     * @param  IRequest  $request
     * @param  IResponse  $response
     */
    public function route(IRequest $request, IResponse $response): void;
}