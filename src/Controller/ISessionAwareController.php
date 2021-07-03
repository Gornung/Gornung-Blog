<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller;

use Gornung\Webentwicklung\Http\Session;

interface ISessionAwareController
{

    /**
     * @return Session
     */
    public function getSession(): Session;
}
