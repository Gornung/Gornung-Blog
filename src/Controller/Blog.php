<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller;

use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Model\BlogPost;
use Gornung\Webentwicklung\Exceptions\NotFoundException;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\View\BlogPost\Add as AddView;
use Gornung\Webentwicklung\View\BlogPost\Show as ShowView;
use Respect\Validation\Validator;

class Blog
{

    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     */
    public function add(IRequest $request, IResponse $response): void
    {
        if (!$request->hasParameter('title')) {
            $view = new AddView();
            $response->setBody($view->render([]));
        } else {
            Validator::allOf(Validator::notEmpty(), Validator::stringType())
                     ->check($request->getParameters()['title']);
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            )->check($request->getParameters()['urlKey']);
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            )->check($request->getParameters()['author']);
            Validator::allOf(Validator::notEmpty(), Validator::stringType())
                     ->check($request->getParameters()['text']);

            $blogPost         = new BlogPost();
            $blogPost->title  = $request->getParameter('title');
            $blogPost->urlKey = $request->getParameter('urlKey');
            $blogPost->author = $request->getParameter('author');
            $blogPost->text   = $request->getParameter('text');
            $repository       = new BlogPostRepository();
            $repository->add($blogPost);
            $response->setBody('great success');
        }
    }

    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @throws \Gornung\Webentwicklung\Exceptions\NotFoundException
     */
    public function show(IRequest $request, IResponse $response): void
    {
        $repository = new BlogPostRepository();
        $view       = new ShowView();

        $lastSlash       = strripos($request->getUrl(), '/') ?: 0;
        $potentialUrlKey = substr($request->getUrl(), $lastSlash + 1);

        $entry = $repository->getByUrlKey($potentialUrlKey);

        if (!$entry) {
            throw new NotFoundException();
        }

        foreach ($entry as $key => $item) {
            $entry->$key = htmlspecialchars($item);
        }

        $response->setBody($view->render(['entry' => $entry]));
    }
}
