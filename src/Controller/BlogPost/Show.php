<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\BlogPost;

use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException;
use Gornung\Webentwicklung\Exceptions\NotFoundException;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\View\BlogPost\Show as ShowView;

class Show extends AbstractController
{

    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @throws \Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException
     * @throws \Gornung\Webentwicklung\Exceptions\NotFoundException
     */
    public function show(
        IRequest $request,
        IResponse $response
    ): void {
        //check if user is logged in
        if (!$this->getSession()->isLoggedIn()) {
            throw new AuthenticationRequiredException();
        }

        $repository = new BlogPostRepository();
        $view       = new ShowView();

        $lastSlash       = strripos($request->getUrl(), '/') ?: 0;
        $potentialUrlKey = substr($request->getUrl(), $lastSlash + 1);
        $entry           = $repository->getByUrlKey($potentialUrlKey);

        // TODO: Write BaseController with Session to get admin differently
        // add to entry object the Session
        if ($entry != null) {
            /**
             * @psalm-suppress UndefinedPropertyAssignment
             *
             * assigning to get the session and see through the session if the user is admin and his username
             */
            $entry->{"session"} = $this->getSession()->getEntries();
        }

        if ($entry) {
            $response->setBody($view->render($entry));
        } else {
            throw new NotFoundException();
        }
    }
}
