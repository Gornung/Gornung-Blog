<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Model\BlogPost;
use Gornung\Webentwicklung\Exceptions\NotFoundException;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\View\BlogPost\Add as AddView;
use Gornung\Webentwicklung\View\BlogPost\Show as ShowView;
use Respect\Validation\Validator;

class BlogController
{

    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     */
    public function add(IRequest $request, IResponse $response): void
    {
        if (!$request->hasParameter('title')) {
            $view = new AddView();
            $response->setBody($view->render([]));
        } else {
            Validator::allOf(Validator::notEmpty(), Validator::stringType())
                     ->check($request->getParameters()['title']);
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            )->check($request->getParameters()['author']);
            Validator::allOf(Validator::notEmpty(), Validator::stringType())
                     ->check($request->getParameters()['text']);


            $urlSlug = $this->generateUrlSlug(
                $request->getParameter('title')
            );

            // escape potential xss TODO scales bad write globaly
            $requestTitle  = htmlspecialchars(
                $request->getParameter('title'),
                ENT_QUOTES,
                'UTF-8'
            );
            $requestAuthor = htmlspecialchars(
                $request->getParameter('author'),
                ENT_QUOTES,
                'UTF-8'
            );
            $requestText   = htmlspecialchars(
                $request->getParameter('text'),
                ENT_QUOTES,
                'UTF-8'
            );

            $blogPostRepository = new BlogPostRepository();
            $blogPost           = $blogPostRepository->getByUrlKey($urlSlug);
            $link               = "show/" . $urlSlug;

            try {
                if ($blogPost == null) {
                    $blogPostModel = new BlogPost(
                        $requestTitle,
                        $requestText,
                        $requestAuthor,
                        $urlSlug
                    );
                    $blogPostRepository->add($blogPostModel);
                    $response->setBody(
                        'Herzlichen Glückwunsch! Dein Blogeintrag findest du <a href="' . $link . '">hier</a>.'
                    );
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
     * @throws \Gornung\Webentwicklung\Exceptions\NotFoundException|\Gornung\Webentwicklung\Exceptions\DatabaseException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function show(
        IRequest $request,
        IResponse $response
    ): void {
        $repository = new BlogPostRepository();
        $view       = new ShowView();

        $lastSlash       = strripos($request->getUrl(), '/') ?: 0;
        $potentialUrlKey = substr($request->getUrl(), $lastSlash + 1);

        $entry = $repository->getByUrlKey($potentialUrlKey);

        if ($entry) {
            $response->setBody($view->render($entry));
        } else {
            throw new NotFoundException();
        }
    }
}
