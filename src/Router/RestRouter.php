<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Router;

use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Http\RestRequest;

class RestRouter implements RouterInterface
{

    public const REST_ENDPOINT_IDENTIFIER = 'rest';

    protected array $routes = [];

    public function addRoute(
        string $route,
        string $controllerName,
        string $actionName,
        string $methode
    ): void {
        $this->routes[$route][$methode] = [
          'controller' => $controllerName,
          'action'     => $actionName,
        ];
    }

    public function route(IRequest $request, IResponse $response): bool
    {
        $url = strtolower($request->getUrl());
        if (strpos($url, static::REST_ENDPOINT_IDENTIFIER) === false) {
            return false;
        }

        $request = RestRequest::fromRequestInstance($request);

        foreach ($this->routes as $route => $methodeArray) {
            $pattern = '/^\/' . static::REST_ENDPOINT_IDENTIFIER . $route . '/';
            $matches = [];
            if (preg_match($pattern, $url, $matches)) {
                unset($matches[0]);
                $request->setIdentifiers($matches);
                foreach ($methodeArray as $methode => $controllerArray) {
                    if (
                        strtolower($methode) === strtolower(
                            $request->getMethode()
                        )
                    ) {
                        $controller = new $controllerArray['controller']();
                        $action     = $controllerArray['action'];
                        $controller->$action($request, $response);
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
