<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\BlogPost;

use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Controller\IController;
use Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Model\BlogPost;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\View\BlogPost\Search as SearchView;

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
        $keyword    = $request->getParameters()['search_txt'];
        $repository = new BlogPostRepository();

        if ($keyword != null) {
            $data = $repository->getByKeyword($keyword);
        }

        $arrayOfBlogPost = [];

        foreach ($data as $blogPostEntry) {
            /**
             * @psalm-suppress UndefinedMethod
             */
            $title = $blogPostEntry['title'];
            /**
             * @psalm-suppress UndefinedMethod
             */
            $text = $blogPostEntry['text'];
            /**
             * @psalm-suppress UndefinedMethod
             */
            $author = $blogPostEntry['author'];

            $blogpost = new BlogPost();
            $blogpost->setTitle($title);
            $blogpost->setText($text);
            $blogpost->setAuthor($author);
            $arrayOfBlogPost[] = $blogpost;
        }

        $view = new SearchView();
        $response->setBody($view->render($arrayOfBlogPost));
    }
}
