<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\Auth;

use Doctrine\ORM\ORMException;
use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Controller\IController;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Model\User;
use Gornung\Webentwicklung\Repository\BlogUserRepository;
use Gornung\Webentwicklung\View\Auth\SignUp as SignUpView;
use Respect\Validation\Validator as v;

class SignUp extends AbstractController implements IController
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
        $username     = $this->preventXss(
            trim($request->getParameters()['username'])
        );
        $emailAddress = $this->preventXss(
            trim($request->getParameters()['email'])
        );
        // Xss not necessary because it will be hashed afterwards otherwise the
        // PW "<script>alter('DONE');</script>" would be changed, maybe im wrong
        $password        = $request->getParameters()['password'];
        $confirmPassword = $request->getParameters()['confirm_password'];

        // TODO: write in AbstractController a function for other validation cases
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
                'Die Passw??rter sind nicht identisch.',
            ];
            // issue with this kind of rerender the values getting lost
            // TODO: Fix rerender, without losing input-data
            $response->setBody($signUpView->render($error));
            return;
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $userRepository = new BlogUserRepository();
        $user           = $userRepository->getByUsername($username);


        try {
            if ($user == null && $password != null && $emailAddress != null) {
                $userModel = new User($username, $password, $emailAddress);
                $userRepository->add($userModel);
                // TODO: transfer functionality "renderAlert" as function
                $success = [
                  'successMessage' =>
                    'Herzlichen Gl??ckwunsch! Melde dich <a href="/auth/login">hier</a> an.',
                ];
                $response->setBody($signUpView->render($success));
            } else {
                // TODO: transfer functionality "renderAlert" as function
                $error = [
                  'errorMessage' =>
                    'Der User ist bereits vergeben! Bitte w??hle einen anderen Usernamen.',
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

    /**
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     */
    private function handleForm(IResponse $response): void
    {
        $view = new SignUpView();
        $response->setBody($view->render([]));
    }
}
