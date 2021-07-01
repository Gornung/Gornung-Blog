<?php

declare(strict_types=1);

use Gornung\Webentwicklung\Http\Request;
use Gornung\Webentwicklung\Http\Response;
use Gornung\Webentwicklung\Router;
use Gornung\Webentwicklung\Controller\Blog as BlogController;
use Gornung\Webentwicklung\Exceptions\NotFoundException;

require __DIR__ . '/../vendor/autoload.php';

$request = new Request();
$request->setUrl($_SERVER['REQUEST_URI']);
$request->setParameters($_REQUEST);

$response = new Response();

$router = new Router();

$router->addRoute('/blog/show', BlogController::class, 'show');
$router->addRoute('/blog/add', BlogController::class, 'add');

try {
    $router->route($request, $response);
} catch (NotFoundException $exception) {
    $response->setStatusCode($exception->getCode());
    $response->setBody('Sorry, 404');
} catch (\Exception $exception) {
    $response->setStatusCode(500);
    $response->setBody('Uh Oh ...');
}

http_response_code($response->getStatusCode());
echo $response->getBody();
