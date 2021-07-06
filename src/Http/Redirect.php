<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Http;

class Redirect implements IRedirect
{

    private string $route;

    private IResponse $response;

    /**
     * Redirect constructor.
     *
     * @param  string  $route
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     */
    public function __construct(string $route, IResponse $response)
    {
        $this->route    = $route;
        $this->response = $response;
    }

    public function execute(): void
    {
        $this->redirect($this->route);

        $this->response->setStatusCode(307);
    }

    /**
     * @param  string  $route
     */
    public function redirect(string $route): void
    {
        header("Location: " . $route);
    }
}
