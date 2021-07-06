<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\BlogPost;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Http\Redirect;
use Gornung\Webentwicklung\Model\BlogPost;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\View\BlogPost\Add as AddView;

class Add extends AbstractController
{

    /**
     * @throws \Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException
     */
    public function add(IRequest $request, IResponse $response): void
    {
        if (!$this->getSession()->isLoggedIn()) {
            throw new AuthenticationRequiredException();
        }

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
            $link               = "show/" . $urlSlug;
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
                    $redirect = new Redirect("$link", $response);
                    $redirect->execute();
                } else {
                    $response->setBody(
                        'Der Titel ist bereits vergeben, bitte gehe zurück.'
                    );
                }
            } catch (OptimisticLockException | ORMException $e) {
                $response->setBody(
                    'Leider ist ein Fehler bei der Erstellung des Blogs entstanden.'
                );
            }
        }
    }
}
