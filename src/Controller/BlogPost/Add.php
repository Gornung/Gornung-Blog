<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\BlogPost;

use Gornung\Webentwicklung\Controller\IController;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;

class Add implements IController
{

    /**
     * @param   IRequest   $request
     * @param   IResponse  $response
     *
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function execute(IRequest $request, IResponse $response)
    {
        if (isset($request->getParameters()['title'])) {
            $this->handleNew($request, $response);
        } else {
            $this->handleForm($response);
        }
    }

    /**
     * @param   IRequest   $request
     * @param   IResponse  $response
     *
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handleNew(IRequest $request, IResponse $response)
    {
        $model = new BlogPostModel();
        $model->setTitle($request->getParameters()['title']);
        $model->setAuthor($session->get('username'));
        $model->setText($request->getParameters()['text']);

        $repository = new BlogPostRepository();
        $repository->add($model);

        $redirect = new Redirect('/', $response);
        $redirect->execute();
    }

    /**
     * @param   IResponse  $response
     *
     * @return void
     */
    public function handleForm(IResponse $response)
    {
        $view = new AddView();
        $response->setBody($view->render([]));
    }
}
