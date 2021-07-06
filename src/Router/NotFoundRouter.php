<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Router;

use Gornung\Webentwicklung\Exceptions\NotFoundException;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;

class NotFoundRouter implements RouterInterface
{

    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @return bool
     * @throws \Gornung\Webentwicklung\Exceptions\NotFoundException
     */
    public function route(IRequest $request, IResponse $response): bool
    {
        throw new NotFoundException();
    }

    /**
     * @param  string  $route
     * @param  string  $controllerName
     * @param  string  $actionName
     * @param  string  $methode
     */
    public function addRoute(
        string $route,
        string $controllerName,
        string $actionName,
        string $methode
    ): void {
        // TODO: Implement addRoute() method.
    }
}
