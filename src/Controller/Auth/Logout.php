<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\Auth;

use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Http\Redirect;

class Logout extends AbstractController
{

    public function logout(IRequest $request, IResponse $response): void
    {
        $this->getSession()->destroy();
        $redirect = new Redirect('/auth/login', $response);
        $redirect->execute();
    }
}
