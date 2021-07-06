<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Router;

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
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @return bool
     */
    public function route(
        IRequest $request,
        IResponse $response
    ): bool {
        $url = strtolower($request->getUrl());
        foreach ($this->routes as $route => $controllerArray) {
            if (strpos($url, $route) !== false) {
                $controller = new $controllerArray['controller']();
                $action     = $controllerArray['action'];
                $controller->$action($request, $response);
                return true;
            }
        }
        return false;
    }
}
