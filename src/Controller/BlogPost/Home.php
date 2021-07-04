<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\BlogPost;

use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Controller\IController;
use Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\View\BlogPost\Home as HomeView;

class Home extends AbstractController implements IController
{
    // TODO: build BaseController

    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @return void
     * @throws \Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException
     */
    public function execute(IRequest $request, IResponse $response): void
    {
        //check if user is logged in
        if (!$this->getSession()->isLoggedIn()) {
            throw new AuthenticationRequiredException();
        }

        $this->handle($response);
    }

    public function handle(IResponse $response)
    {
        $repository = new BlogPostRepository();
        $data       = $repository->get();

        $view = new HomeView();
        $response->setBody($view->render($data));
    }
}
