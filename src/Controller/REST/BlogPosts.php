<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\REST;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Exceptions\NotFoundException;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Http\IRestAware;
use Gornung\Webentwicklung\Model\BlogPost;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\View\BlogPost\Add as AddView;
use Gornung\Webentwicklung\View\REST\JsonView;

class BlogPosts extends AbstractController
{

    // TODO: Authentication and REST Response
    public function add(IRequest $request, IResponse $response): void
    {
        if (!$request->hasParameter('title')) {
            $view = new AddView();
            $response->setBody($view->render([]));
        } else {
            $title  = $this->preventXss($request->getParameter('title'));
            $author = $this->preventXss($request->getParameter('author'));
            $text   = $this->preventXss($request->getParameter('text'));

            // validation
            $this->validateNotEmptyAndString($title);
            $this->validateNotEmptyAndString($author);
            $this->validateNotEmptyAndString($text);

            $urlSlug = $this->generateUrlSlug(
                $request->getParameter('title')
            );

            $blogPostRepository = new BlogPostRepository();
            $blogPost           = $blogPostRepository->getByUrlKey($urlSlug);
            $creator            = $this->getSession()->getEntry('username');

            try {
                if ($blogPost == null) {
                    $blogPostModel = new BlogPost(
                        $title,
                        $text,
                        $author,
                        $urlSlug
                    );
                    $blogPostModel->setCreator($creator);
                    $this->getSession()->setEntry('username', $creator);
                    $blogPostRepository->add($blogPostModel);
                    $response->setStatusCode(200);
                } else {
                    $response->setStatusCode(500);
                    $response->setBody(
                        'Der Titel ist bereits vergeben, bitte gehe zurück.'
                    );
                }
            } catch (OptimisticLockException | ORMException $e) {
                $response->setStatusCode(500);
                $response->setBody(
                    'Leider ist ein Fehler bei der Erstellung des Blogs entstanden.'
                );
            }
        }
    }

    /**
     * @param  \Gornung\Webentwicklung\Http\IRestAware  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @throws \Gornung\Webentwicklung\Exceptions\NotFoundException
     */
    public function getByKeyword(IRestAware $request, IResponse $response): void
    {
        $repository = new BlogPostRepository();


        $keyword   = $this->preventXss($request->getParameter('keyword'));

        $entry = $repository->getByKeyword($keyword);

        // TODO: error handling needs to be different for webservices!
        if (!$entry) {
            throw new NotFoundException();
        }


        $view = new JsonView();

        // TODO: here comes the encoding part
        $response->setBody($view->render($entry));
    }

    /**
     * @param  \Gornung\Webentwicklung\Http\IRestAware  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @throws \Gornung\Webentwicklung\Exceptions\NotFoundException
     */
    public function getByUrlKey(
        IRestAware $request,
        IResponse $response
    ): void {
        $repository = new BlogPostRepository();

        // get blog entry from database
        $entry = $repository->getByUrlKey(current($request->getIdentifiers()));

        // TODO: error handling needs to be different for webservices!
        if (!$entry) {
            throw new NotFoundException();
        }

        $view = new JsonView();

        // TODO: here comes the encoding part
        $response->setBody($view->render($entry));
    }
}
