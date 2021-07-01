<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Http;

class Redirect implements IRedirect
{

    private string $route;

    private IResponse $response;

    public function __construct($route, IResponse $response)
    {
        $this->route    = $route;
        $this->response = $response;
    }

    public function execute(): void
    {
        $this->redirect($this->route);

        $this->response->setStatusCode(307);
    }

    public function redirect(string $route): void
    {
        header("Location: " . $route);
    }
}
