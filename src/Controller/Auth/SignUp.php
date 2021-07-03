<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\Auth;

use Doctrine\ORM\ORMException;
use Gornung\Webentwicklung\Controller\IController;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Http\Redirect;
use Gornung\Webentwicklung\Model\User;
use Gornung\Webentwicklung\Repository\BlogUserRepository;
use Gornung\Webentwicklung\View\Auth\SignUp as SignUpView;
use Respect\Validation\Validator as v;

class SignUp implements IController
{

    public function execute(IRequest $request, IResponse $response): void
    {
        if (isset($request->getParameters()['username'])) {
            $this->signUp($request, $response);
        } else {
            $this->handleForm($response);
        }
    }

    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     */
    private function signUp(IRequest $request, IResponse $response)
    {
        $username         = $request->getParameters()['username'];
        $password         = $request->getParameters()['password'];
        $emailAddress     = $request->getParameters()['email'];
        $confirm_password = $request->getParameters()['confirm_password'];

        v::allOf(v::notEmpty(), v::length(5, 100), v::stringType())->check(
            $username
        );

        v::anyOf(v::email(), v::length(5))->check(trim($username));
        v::stringType()->check(trim($emailAddress));

        v::length(8, 50)->setName('Password')->check($password);
        v::stringType()->check($password);

        if (strcmp($password, $confirm_password) != 0) {
            $this->handleForm($response);
        }

        // escape potential xss TODO scales bad write globaly
        $username     = htmlspecialchars(
            $username,
            ENT_QUOTES,
            'UTF-8'
        );
        $emailAddress = htmlspecialchars(
            $emailAddress,
            ENT_QUOTES,
            'UTF-8'
        );

        $password = password_hash($password, PASSWORD_DEFAULT);

        $userRepository = new BlogUserRepository();
        $user           = $userRepository->getByUsername($username);

        try {
            if ($user == null) {
                $userModel = new User($username, $password, $emailAddress);
                $userRepository->add($userModel);
                $response->setBody(
                    'Herzlichen Glückwunsch! Du bist nun erfolgreich registriert.'
                );
            } else {
                $response->setBody(
                    'Der User ist bereits vergeben, bitte gehe zurück.'
                );
            }
        } catch (ORMException $e) {
            $response->setBody(
                'Leider ist ein Fehler bei der Erstellung des Users entstanden.'
            );
        }

        //redirect to Login page
        $redirect = new Redirect('/auth/login', $response);
        $redirect->execute();
    }

    public function handleForm(IResponse $response)
    {
        $view = new SignUpView();
        $response->setBody($view->render([]));
    }
}
