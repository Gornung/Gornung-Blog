<?php

namespace Gornung\Webentwicklung\Router;

use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;

// IRouter won't compile idc why :D rather IntelliJ doesn't recognize as interface
interface RouterInterface
{

    /**
     * @param  IRequest  $request
     * @param  IResponse  $response
     */
    public function route(IRequest $request, IResponse $response): bool;
}
