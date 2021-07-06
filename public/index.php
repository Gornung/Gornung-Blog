<?php

declare(strict_types=1);

use Gornung\Webentwicklung\Controller\Auth\Login as LoginController;
use Gornung\Webentwicklung\Controller\Auth\Logout as LogoutController;
use Gornung\Webentwicklung\Controller\Auth\SignUp as SignUpController;
use Gornung\Webentwicklung\Controller\BlogPost\Add as AddController;
use Gornung\Webentwicklung\Controller\BlogPost\Delete as DeleteController;
use Gornung\Webentwicklung\Controller\BlogPost\Edit as EditController;
use Gornung\Webentwicklung\Controller\BlogPost\Home as HomeController;
use Gornung\Webentwicklung\Controller\BlogPost\Search as SearchController;
use Gornung\Webentwicklung\Controller\BlogPost\Show as ShowController;
use Gornung\Webentwicklung\Controller\REST\BlogPosts as BlogPostsRestController;
use Gornung\Webentwicklung\Controller\REST\Users as BlogUsersRestController;
use Gornung\Webentwicklung\Exceptions\AuthenticationRequiredException;
use Gornung\Webentwicklung\Exceptions\ForbiddenException;
use Gornung\Webentwicklung\Exceptions\NotFoundException;
use Gornung\Webentwicklung\Http\Redirect;
use Gornung\Webentwicklung\Http\Request;
use Gornung\Webentwicklung\Http\Response;
use Gornung\Webentwicklung\Router\RestRouter;
use Gornung\Webentwicklung\Router\Router;
use Respect\Validation\Exceptions\ValidationException;

date_default_timezone_set('Europe/Berlin');

require __DIR__ . '/../vendor/autoload.php';

$request = new Request($_SERVER['REQUEST_URI'], $_REQUEST);

$routers = [];

$restRouter = new RestRouter();
$routers[]  = $restRouter;

$restRouter->addRoute(
    '\/blogposts\/(\S+)',
    BlogPostsRestController::class,
    'getByUrlKey',
    'GET'
);

$restRouter->addRoute(
    '\/blogposts-add',
    BlogPostsRestController::class,
    'add',
    'GET'
);

$restRouter->addRoute(
    '\/users\/(\S+)',
    BlogUsersRestController::class,
    'getByUsername',
    'GET'
);

$router    = new Router();
$routers[] = $router;

$response = new Response('', 200, []);
$redirect = new Redirect('/home', $response);

$router->addRoute('/home', HomeController::class, 'execute');

$router->addRoute('/blog/show', ShowController::class, 'show');
$router->addRoute('/blog/add', AddController::class, 'add');
$router->addRoute('/blog/delete', DeleteController::class, 'delete');
$router->addRoute('/blog/search', SearchController::class, 'execute');
$router->addRoute('/blog/edit', EditController::class, 'edit');

$router->addRoute('/auth/login', LoginController::class, 'execute');
$router->addRoute('/auth/signup', SignUpController::class, 'execute');
$router->addRoute('/auth/logout', LogoutController::class, 'logout');

if ($request->getUrl() == '/') {
    // TODO: better rewrite in redirect to visibly see the url
    $request->setUrl('/home');
}


try {
    // iterates over router array
    foreach ($routers as $router) {
        if ($router->route($request, $response)) {
            break;
        }
    }
} catch (NotFoundException $exception) {
    // 404
    $response->setStatusCode($exception->getCode());
    $response->setBody('Sorry, 404, <a href="/auth/login">Zur Homepage</a>');
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
} catch (ForbiddenException $exception) {
    $response->setStatusCode($exception->getCode());
    $response->setBody($exception->getMessage());
} catch (Exception $exception) {
    // 500 some error will be catched
    $response->setStatusCode(500);
    $response->setBody('Leider ist etwas schiefgelaufen versuche es erneut.');
}

http_response_code($response->getStatusCode());
echo $response->getBody();
