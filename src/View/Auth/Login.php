<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\View\Auth;

use Gornung\Webentwicklung\View\AbstractView;

class Login extends AbstractView
{

    /**
     * @return string
     */
    protected function getTemplatePath(): string
    {
        return '/view/templates/auth/login.html';
    }
}
