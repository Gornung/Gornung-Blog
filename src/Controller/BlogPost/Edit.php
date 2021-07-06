<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\BlogPost;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException;
use Gornung\Webentwicklung\Exceptions\DatabaseException;
use Gornung\Webentwicklung\Exceptions\ForbiddenException;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Http\Redirect;
use Gornung\Webentwicklung\Model\BlogPost;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\View\BlogPost\Edit as EditView;

class Edit extends AbstractController
{

    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @throws \Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException
     * @throws \Gornung\Webentwicklung\Exceptions\ForbiddenException
     * @throws \Gornung\Webentwicklung\Exceptions\DatabaseException
     */
    public function edit(IRequest $request, IResponse $response): void
    {
        if (!$this->getSession()->isLoggedIn()) {
            throw new AuthenticationRequiredException();
        }

        $blogPostRepository = new BlogPostRepository();
        $lastSlash          = strripos($request->getUrl(), '/') ?: 0;
        $potentialUrlKey    = substr($request->getUrl(), $lastSlash + 1);
        $userName           = $this->getSession()->getEntry('username');
        $post               = $blogPostRepository->getByUrlKey(
            $potentialUrlKey
        );

        if ($post == null) {
            return;
        }

        // check if user NOT admin or creator of Post
        if (
            !$this->getSession()->getEntry(
                'isAdmin'
            ) && $userName != $post->getCreator()
        ) {
            throw new ForbiddenException();
        }

        if (!$request->hasParameter('title')) {
            $this->render($response, $post);
            return;
        }

        $title  = $this->preventXss($request->getParameter('title'));
        $author = $this->preventXss($request->getParameter('author'));
        $text   = $this->preventXss($request->getParameter('text'));

        $this->validateNotEmptyAndString($title);
        $this->validateNotEmptyAndString($author);
        $this->validateNotEmptyAndString($text);


        //check differences
        if (
            $title == $post->getTitle() &&
            $text == $post->getText() &&
            $author == $post->getAuthor()
        ) {
            $this->render($response, $post);
            return;
        }

        try {
            // TODO: Fix UrlKey Change doesn't update urlKey
            $potentialNewUrlKey = $this->generateUrlSlug($title);
            $post->setTitle($title);
            $post->setAuthor($author);
            $post->setText($text);
            $post->setUrlKey($potentialNewUrlKey);

            $blogPostRepository->update($post);
        } catch (OptimisticLockException | ORMException $e) {
            throw new DatabaseException(
                'Es ist beim Editieren zu einem Fehler gekommen.'
            );
        }

        $potentialChangedUrl = $post->getUrlKey();

        $redirect = new Redirect("/blog/show/$potentialChangedUrl", $response);
        $redirect->execute();
    }

    /**
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     * @param  \Gornung\Webentwicklung\Model\BlogPost  $post
     */
    public function render(IResponse $response, BlogPost $post): void
    {
        /**
         * add Session into the Blogpost for rendering conditional
         *
         * @psalm-suppress UndefinedPropertyAssignment
         */
        $post->{"session"} = $this->getSession()->getEntries();
        $view              = new EditView();
        // TODO: make post to an array
        $response->setBody($view->render($post));
    }
}
