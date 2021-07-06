<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\BlogPost;

use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException;
use Gornung\Webentwicklung\Exceptions\ForbiddenException;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Http\Redirect;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\Repository\BlogUserRepository;

class Delete extends AbstractController
{


    /**
     * gets url slug then id and run remove
     *
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @throws \Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException
     * @throws \Gornung\Webentwicklung\Exceptions\ForbiddenException
     */
    public function delete(IRequest $request, IResponse $response): void
    {
        if (!$this->getSession()->isLoggedIn()) {
            throw new AuthenticationRequiredException();
        }

        if (!$this->getSession()->getEntry('isAdmin')) {
            throw new ForbiddenException();
        }

        $blogPostRepository = new BlogPostRepository();
        $lastSlash          = strripos($request->getUrl(), '/') ?: 0;
        $potentialUrlKey    = substr($request->getUrl(), $lastSlash + 1);

        $blog = $blogPostRepository->getByUrlKey($potentialUrlKey);

        if ($blog != null) {
            $blogPostRepository->removeById($blog->getId());
        }

        $redirect = new Redirect('/home', $response);
        $redirect->execute();
    }


    /**
     * we are getting the Admin through the session should be
     * rewritten to set the admin flag in session but through the db
     *
     * @return bool
     */
    private function isAdmin(): bool
    {
        if (!$this->getSession()->isLoggedIn()) {
            return false;
        }

        $username = $this->getSession()->getEntry('username');

        if ($username == null) {
            return false;
        }

        $userRepository = new BlogUserRepository();
        $user           = $userRepository->getByUsername($username);

        if ($user == null) {
            return false;
        }

        return $user->getAdminStatus();
    }
}
