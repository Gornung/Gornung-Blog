<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Controller\Auth;

use Exception;
use Gornung\Webentwicklung\Controller\AbstractController;
use Gornung\Webentwicklung\Controller\IController;
use Gornung\Webentwicklung\Http\IRequest;
use Gornung\Webentwicklung\Http\IResponse;
use Gornung\Webentwicklung\Http\Redirect;
use Gornung\Webentwicklung\Model\User;
use Gornung\Webentwicklung\Repository\BlogUserRepository;
use Gornung\Webentwicklung\View\Auth\Login as LoginView;
use Respect\Validation\Validator as v;

class Login extends AbstractController implements IController
{


    /**
     * @throws \Exception
     */
    public function execute(IRequest $request, IResponse $response): void
    {
        if (isset($request->getParameters()['username'])) {
            $this->login($request, $response);
        } elseif ($this->getSession()->isLoggedIn()) {
            //if allready logged in route to /home
            $redirect = new Redirect('/home', $response);
            $redirect->execute();
        } else {
            $this->handleFormLogin($response);
        }
    }


    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     *
     * @throws \Exception
     */
    public function login(IRequest $request, IResponse $response): void
    {
        $username = $request->getParameters()['username'];
        $password = $request->getParameters()['password'];

        v::anyOf(v::notEmpty(), v::length(5, 100))->validate(trim($username));
        v::stringType()->validate(trim($username));

        v::length(8, 50)->setName('Password')->check($password);
        v::stringType()->check($password);

        $username = htmlspecialchars(
            $username,
            ENT_QUOTES,
            'UTF-8'
        );

        $userRepository = new BlogUserRepository();
        $user           = $userRepository->getByUsername($username);
        $hash           = '';

        // user testing deferred for timing reasons
        if ($user instanceof User) {
            $hash = $user->getPassword();
        }

        if (password_verify($password, $hash) && $user instanceof User) {
            if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
                $rehashedPassword = (password_hash(
                    $password,
                    PASSWORD_DEFAULT
                ));
                if (!is_string($rehashedPassword)) {
                    throw new Exception(
                        'Could not update user to rehash password'
                    );
                }
                $user->setPassword($rehashedPassword);
                $userRepository->update($user);
            }
            // successful login
            $this->getSession()->login();

            $redirect = new Redirect('/home', $response);
            $redirect->execute();
        } else {
            // failed login
            $response->setStatusCode(401);
            $response->setBody(
                'Username oder Passwort ist falsch oder den Account gibt es nicht.'
            );
        }
    }

    /**
     * @param  \Gornung\Webentwicklung\Http\IResponse  $response
     */
    public function handleFormLogin(IResponse $response): void
    {
        $view = new LoginView();
        $response->setBody($view->render([]));
    }
}
