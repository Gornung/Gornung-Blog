<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller;

use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;

/**
 * Controller interface
 *
 * @package Gornung\Webentwicklung
 */
interface IController
{

    /**
     * @param   IRequest   $request
     * @param   IResponse  $response
     *
     * @return void
     */
    public function execute(IRequest $request, IResponse $response);
}
