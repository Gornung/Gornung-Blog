<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung;

use Gornung\Webentwicklung\Http\RequestInterface;
use Gornung\Webentwicklung\Http\ResponseInterface;

class Router
{

    protected array $routes = [];

    public function addRoute(string $route, callable $controller)
    {
        $this->routes[$route] = $controller;
    }

    public function route(
        RequestInterface $request,
        ResponseInterface $response
    ) {
        $url = strtolower($request->getUrl());
        foreach ($this->routes as $route => $controller) {
            if (strpos($url, $route) !== false) {
                $controller($request, $response);
                return;
            }
        }

        $response->setBody('Hello there! ;)');
    }
}
