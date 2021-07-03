<?php

namespace Gornung\Webentwicklung\Controller;

use Gornung\Webentwicklung\Http\Session;

abstract class AbstractController implements ISessionAwareController
{

    protected Session $session;

    public function __construct()
    {
        $this->session = new Session();
        $this->session->start();
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }
}
