<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\Auth;

use Doctrine\ORM\ORMException;
use Gornung\Webentwicklung\Controller\IController;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
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
    public function signUp(IRequest $request, IResponse $response): void
    {
        $username        = trim($request->getParameters()['username']);
        $emailAddress    = trim($request->getParameters()['email']);
        $password        = $request->getParameters()['password'];
        $confirmPassword = $request->getParameters()['confirm_password'];

        v::anyOf(
            v::notEmpty(),
            v::stringType(),
            v::length(5)
        )->check($username);

        v::allOf(
            v::notEmpty(),
            v::stringType(),
            v::email()
        )->check($emailAddress);

        v::anyOf(
            v::notEmpty(),
            v::stringType(),
            v::length(8, 50)
        )->check($password);

        v::anyOf(
            v::notEmpty(),
            v::stringType(),
            v::length(8, 50)
        )->check($confirmPassword);

        $signUpView = new SignUpView();

        if (strcmp($password, $confirmPassword) != 0) {
            // TODO: transfer functionality "renderAlert" as function
            $error = [
              'errorMessage' =>
                'Die Passwörter sind nicht identisch.',
            ];
            // issue with this kind of rerender the values getting lost
            // TODO: Fix rerender, without losing input-data
            $response->setBody($signUpView->render($error));
            return;
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
                // TODO: transfer functionality "renderAlert" as function
                $success = [
                  'successMessage' =>
                    'Herzlichen Glückwunsch! Melde dich <a href="/auth/login">hier</a> an.',
                ];
                $response->setBody($signUpView->render($success));
            } else {
                // TODO: transfer functionality "renderAlert" as function
                $error = [
                  'errorMessage' =>
                    'Der User ist bereits vergeben! Bitte wähle einen anderen Usernamen.',
                ];
                $response->setBody($signUpView->render($error));
            }
        } catch (ORMException $e) {
            // TODO: transfer functionality "renderAlert" as function
            $error = [
              'errorMessage' =>
                'Leider ist ein Fehler bei der Erstellung des Users entstanden. Versuche es erneut',
            ];
            $response->setBody($signUpView->render($error));
        }
    }

    private function handleForm(IResponse $response)
    {
        $view = new SignUpView();
        $response->setBody($view->render([]));
    }
}
