<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\REST;

use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Exceptions\NotFoundException;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Http\IRestAware;
use Gornung\Webentwicklung\Repository\BlogUserRepository;
use Gornung\Webentwicklung\View\REST\JsonView;

class Users extends AbstractController
{

    /**
     * @param  \Gornung\Webentwicklung\Http\IRestAware  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @throws \Gornung\Webentwicklung\Exceptions\NotFoundException
     */
    public function getByUsername(
        IRestAware $request,
        IResponse $response
    ): void {
        $repository = new BlogUserRepository();

        $entry = $repository->getByUsername(current($request->getIdentifiers()));

        // TODO: error handling needs to be different for webservices!
        if (!$entry) {
            throw new NotFoundException();
        }

        $view = new JsonView();

        // TODO: here comes the encoding part
        $response->setBody($view->render($entry));
    }
}
