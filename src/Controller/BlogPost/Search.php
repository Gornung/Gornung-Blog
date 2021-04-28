<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\BlogPost;

use Gornung\Webentwicklung\Controller\IController;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Model\BlogPost;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\View\BlogPost\Show;

class Search implements IController
{

    public function execute(IRequest $request, IResponse $response)
    {
        $this->search($request, $response);
    }

    private function search(IRequest $request, IResponse $response)
    {
        $keyword    = $request->getParameter('search_txt');
        $repository = new BlogPostRepository();
        $data       = $repository->getByKeyword($keyword);

        $blogPostArray = [];

        foreach ($data as $blogPostEntry) {
            $title  = $blogPostEntry['title'];
            $text   = $blogPostEntry['text'];
            $author = $blogPostEntry['author'];

            $blogPost = new BlogPost();
            $blogPost->setAuthor($author);
            $blogPost->setText($text);
            $blogPost->setTitle($title);
            $blogPostArray[] = $blogPost;
        }

        $view = new Show();
        $response->setBody($view->render($blogPostArray));
    }
}
