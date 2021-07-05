<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\BlogPost;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException;
use Gornung\Webentwicklung\Exceptions\NotFoundException;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Http\Redirect;
use Gornung\Webentwicklung\Model\BlogPost;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\View\BlogPost\Add as AddView;
use Gornung\Webentwicklung\View\BlogPost\Show as ShowView;
use Respect\Validation\Validator;

class BlogController extends AbstractController
{

    // TODO: refactor add and show as own controller

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
            $title  = $request->getParameter('title');
            $author = $request->getParameter('author');
            $text   = $request->getParameter('text');

            // validation-layer
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            )->check($title);

            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            )->check($author);

            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            )->check($text);


            $urlSlug = $this->generateUrlSlug(
                $request->getParameter('title')
            );

            // escape potential xss TODO scales bad write globaly
            $title  = htmlspecialchars(
                $title,
                ENT_QUOTES,
                'UTF-8'
            );
            $author = htmlspecialchars(
                $author,
                ENT_QUOTES,
                'UTF-8'
            );
            $text   = htmlspecialchars(
                $text,
                ENT_QUOTES,
                'UTF-8'
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

    /**
     * @param  string  $title
     *
     * @return string
     */
    private function generateUrlSlug(string $title): string
    {
        // TODO handle Umlaute ä -> ae, right now it removes the value
        $slug = strtolower($title);
        //replace non-alphanumerics
        $slug = preg_replace('/[^[:alnum:]]/', ' ', $slug);
        //replace spaces
        $slug = preg_replace('/[[:space:]]+/', '-', $slug);
        return trim($slug, '-');
    }


    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @throws \Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException
     * @throws \Gornung\Webentwicklung\Exceptions\NotFoundException
     */
    public function show(
        IRequest $request,
        IResponse $response
    ): void {
        //check if user is logged in
        if (!$this->getSession()->isLoggedIn()) {
            throw new AuthenticationRequiredException();
        }

        $repository = new BlogPostRepository();
        $view       = new ShowView();

        $lastSlash       = strripos($request->getUrl(), '/') ?: 0;
        $potentialUrlKey = substr($request->getUrl(), $lastSlash + 1);
        $entry = $repository->getByUrlKey($potentialUrlKey);

        // TODO: Write BaseController with Session to get admin differently
        // add to entry object the Session
        if ($entry != null) {
            /**
             * @psalm-suppress UndefinedPropertyAssignment
             */
            $entry->{"session"} = $this->getSession()->getEntries();
        }

        if ($entry) {
            $response->setBody($view->render($entry));
        } else {
            throw new NotFoundException();
        }
    }
}
