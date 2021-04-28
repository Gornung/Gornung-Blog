<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung;

use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;

use function call_user_func;

class Router
{

    protected array $routes = [];

    /**
     * @param   string    $route
     * @param   callable  $controller
     */
    public function addRoute(string $route, callable $controller)
    {
        $this->routes[$route] = $controller;
    }

    /**
     * @param   \Gornung\Webentwicklung\Http\IRequest   $request
     * @param   \Gornung\Webentwicklung\Http\IResponse  $response
     */
    public function route(
      IRequest $request,
      IResponse $response
    ) {
        $url = strtolower($request->getUrl());
        foreach ($this->routes as $route => $controller) {
            if (strpos($url, $route) !== false) {
                \call_user_func($controller, $request, $response);
                return;
            }
        }

        $response->setBody('Hello there! ;)');
    }

}
