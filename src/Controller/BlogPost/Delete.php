<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\BlogPost;

use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Http\Redirect;
use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\Repository\BlogUserRepository;

class Delete extends AbstractController
{

    /**
     * gets url slug then id and run remove
     *
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     */
    public function delete(IRequest $request, IResponse $response): void
    {
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
     * unnecessary because we are faking the view button it throw the Session
     * still can be removed by calling the url NOT SAFE!
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
