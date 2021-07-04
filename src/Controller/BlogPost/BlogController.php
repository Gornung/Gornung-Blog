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
use Gornung\Webentwicklung\Exceptions\NotFoundException;
use Gornung\Webentwicklung\Repository\BlogPostRepository;
use Gornung\Webentwicklung\Repository\BlogUserRepository;
use Gornung\Webentwicklung\View\BlogPost\Add as AddView;
use Gornung\Webentwicklung\View\BlogPost\Show as ShowView;
use Respect\Validation\Validator;

class BlogController extends AbstractController
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
            $title  = $request->getParameters()['title'];
            $author = $request->getParameters()['author'];
            $text   = $request->getParameters()['text'];

            // validation-layer
            Validator::allOf(Validator::notEmpty(), Validator::stringType())
                     ->check($title);

            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            )->check($author);

            Validator::allOf(Validator::notEmpty(), Validator::stringType())
                     ->check($text);


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

            try {
                if ($blogPost == null) {
                    $blogPostModel = new BlogPost(
                        $title,
                        $text,
                        $author,
                        $urlSlug
                    );
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

        if ($entry) {
            $response->setBody($view->render($entry));
        } else {
            throw new NotFoundException();
        }
    }

    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @throws \Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException
     */
    public function delete(IRequest $request, IResponse $response): void
    {
        if (!$this->getSession()->isLoggedIn()) {
            throw new AuthenticationRequiredException();
        }

        if (!$this->isAdmin()) {
            return;
        }

        $blogPostRepository = new BlogPostRepository();


        $idHardcoded = '3113a805-d65a-11ea-b85f-54ee75d56bf9';
        //$id =
        //$blogPostRepository->removeById($id);
    }

    /**
     * @return bool
     */
    private function isAdmin(): bool
    {
        if (!$this->getSession()->isLoggedIn()) {
            return false;
        }

        $username = $this->getSession()->getSessionUsername();

        if ($username == null) {
            return false;
        }

        $userRepository = new BlogUserRepository();
        $user           = $userRepository->getByUsername($username);

        if ($user == null) {
            return false;
        }

        return $user->getAdminStatus();
    }
}
