<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Router;

use Gornung\Webentwicklung\Exceptions\NotFoundException;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;

class Router implements RouterInterface
{

    /**
     * @var array
     */
    protected array $routes = [];

    /**
     * @param  string  $route
     * @param  string  $controllerName
     * @param  string  $actionName
     */
    public function addRoute(
        string $route,
        string $controllerName,
        string $actionName
    ): void {
        $this->routes[$route] = [
          'controller' => $controllerName,
          'action'     => $actionName,
        ];
    }

    /**
     * @param  IRequest  $request
     * @param  IResponse  $response
     */
    public function route(IRequest $request, IResponse $response): void
    {
        $url = strtolower($request->getUrl());
        foreach ($this->routes as $route => $controllerArray) {
            if (strpos($url, $route) !== false) {
                $controller = new $controllerArray['controller']();
                $action     = $controllerArray['action'];
                $controller->$action($request, $response);
                return;
            }
        }

        throw new NotFoundException();
    }
}
