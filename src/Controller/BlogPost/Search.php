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

    private function search(IRequest $request, IResponse $response)
    {
        $searchView = new SearchView();

        if (!$request->hasParameter('search_keyword')) {
            $response->setBody($searchView->render([]));
            return;
        }

        $keyword = $request->getParameter('search_keyword');

        v::allOf(
            v::notEmpty(),
            v::stringType()
        )->check($keyword);

        $blogRepository = new BlogPostRepository();

        // can be rewritten in getByTitleTextOrAuthor($title, $text, $author) with view of those inputs
        $foundBlogPosts = $blogRepository->getByKeyword($keyword);

        $response->setBody($searchView->render($foundBlogPosts));
    }
}
