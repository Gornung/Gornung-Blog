<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\BlogPost;

use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Controller\IController;
use Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\View\BlogPost\Search as SearchView;
use Respect\Validation\Validator as v;

class Search extends AbstractController implements IController
{


    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @return void
     * @throws \Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException
     */
    public function execute(IRequest $request, IResponse $response): void
    {
        if (!$this->getSession()->isLoggedIn()) {
            throw new AuthenticationRequiredException();
        }

        $this->search($request, $response);
    }

    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     */
    private function search(IRequest $request, IResponse $response): void
    {
        $searchView = new SearchView();

        if (!$request->hasParameter('search_keyword')) {
            $response->setBody($searchView->render([]));
            return;
        }

        // prevent xss for every input
        $keyword = $this->preventXss($request->getParameter('search_keyword'));

        $this->validateNotEmptyAndString($keyword);

        $blogRepository = new BlogPostRepository();

        // can be rewritten in getByTitleTextOrAuthor($title, $text, $author) with view of those inputs
        $foundBlogPosts = $blogRepository->getByKeyword($keyword);

        // TODO: $foundBlogPosts entry to an array
        $response->setBody($searchView->render($foundBlogPosts));
    }
}
