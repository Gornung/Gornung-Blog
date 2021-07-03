<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\Auth;

use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;

class Logout extends AbstractController
{

    public function logout(IRequest $request, IResponse $response): void
    {
        $this->getSession()->destroy();
        $response->setBody('Sie wurden ausgeloggt. Möchtest du dich wieder <a href="/auth/login">anmelden</a>?');
    }

}
