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
use Respect\Validation\Validator;

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

        $title  = $request->getParameter('title');
        $author = $request->getParameter('author');
        $text   = $request->getParameter('text');

        $this->validate($title);
        $this->validate($author);
        $this->validate($text);

        try {
            $blogPostRepository->update($post);
        } catch (OptimisticLockException | ORMException $e) {
            throw new DatabaseException(
                'Es ist beim Editieren zu einem Fehler gekommen.'
            );
        }

        //check differences
        if (
            $title == $post->getTitle() &&
            $text == $post->getText() &&
            $author == $post->getAuthor()
        ) {
            $this->render($response, $post);
            return;
        }

        $redirect = new Redirect('/post/show/.$potentialUrlKey.', $response);
        $redirect->execute();
    }

    /**
     * @param $value
     */
    private function validate($value): void
    {
        Validator::allOf(
            Validator::notEmpty(),
            Validator::stringType()
        )->check($value);
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
        $response->setBody($view->render($post));
    }
}
