<?php

namespace Gornung\Webentwicklung\Controller\BlogPost;

use Gornung\Webentwicklung\Controller\IController;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\View\BlogPost\Show;

class Index implements IController
{

    public function execute(IRequest $request, IResponse $response)
    {
        $this->handle($response);
    }

    public function handle(IResponse $response)
    {
        $repository = new BlogPostRepository();
        $data       = $repository->get();

        $view = new Show();
        $response->setBody($view->render($data));
    }
}
