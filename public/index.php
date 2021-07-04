<?php

declare(strict_types=1);

use Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException;
use Gornung\Webentwicklung\Http\Redirect;
use Gornung\Webentwicklung\Http\Request;
use Gornung\Webentwicklung\Http\Response;
use Gornung\Webentwicklung\Router;
use Gornung\Webentwicklung\Controller\BlogPost\BlogController;
use Gornung\Webentwicklung\Controller\BlogPost\Search as SearchController;
use Gornung\Webentwicklung\Controller\Auth\Login as LoginController;
use Gornung\Webentwicklung\Controller\Auth\SignUp as SignUpController;
use Gornung\Webentwicklung\Controller\Auth\Logout as LogoutController;
use Gornung\Webentwicklung\Exceptions\NotFoundException;
use Gornung\Webentwicklung\Controller\BlogPost\Home as HomeController;
use Respect\Validation\Exceptions\ValidationException;

date_default_timezone_set('Europe/Berlin');

require __DIR__ . '/../vendor/autoload.php';

$request = new Request();
$request->setUrl($_SERVER['REQUEST_URI']);
$request->setParameters($_REQUEST);

$response = new Response();
$router   = new Router();
$redirect = new Redirect('/home', $response);

$router->addRoute('/home', HomeController::class, 'execute');

$router->addRoute('/blog/show', BlogController::class, 'show');
$router->addRoute('/blog/add', BlogController::class, 'add');
$router->addRoute('/blog/delete', BlogController::class, 'delete');
$router->addRoute('/blog/search', SearchController::class, 'execute');

$router->addRoute('/auth/login', LoginController::class, 'execute');
$router->addRoute('/auth/signup', SignUpController::class, 'execute');
$router->addRoute('/auth/logout', LogoutController::class, 'logout');

if ($request->getUrl() == '/') {
    //better rewrite in redirect to visibly see the url
    $request->setUrl('/home');
}


try {
    $router->route($request, $response);
} catch (NotFoundException $exception) {
    // 404
    $response->setStatusCode($exception->getCode());
    $response->setBody('Sorry, 404');
} catch (AuthenticationRequiredException $exception) {
    // 401 react on missing login
    $response->setStatusCode($exception->getCode());
    $response->setBody(
        'Ein Login wird benötigt! <a href="/auth/login">Zum Login</a>'
    );
} catch (ValidationException $exception) {
    // generic validation exception handling for validation - better is js validation
    $response->setStatusCode($exception->getCode());
    $response->setBody(
        'Bei der Validierung ist es zu einem Fehler gekommen. Versuche es erneut'
    );
} catch (Exception $exception) {
    // 500 some error will be catched
    dd($exception);
    $response->setStatusCode(500);
    $response->setBody('Uh Oh ...');
}

http_response_code($response->getStatusCode());
echo $response->getBody();
