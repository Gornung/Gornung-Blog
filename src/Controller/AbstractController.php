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

    /**
     * @param  string  $title
     *
     * @return string
     */
    public function generateUrlSlug(string $title): string
    {
        // TODO handle Umlaute ä -> ae, right now it removes the value
        $slug = strtolower($title);
        //replace non-alphanumerics
        $slug = preg_replace('/[^[:alnum:]]/', ' ', $slug);
        //replace spaces
        $slug = preg_replace('/[[:space:]]+/', '-', $slug);
        return trim($slug, '-');
    }
}
