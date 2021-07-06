<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller;

use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;

// should write a better interface and use it everywhere resolved most solutions through inheritance
interface IController
{

    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @return void
     */
    public function execute(IRequest $request, IResponse $response): void;
}
