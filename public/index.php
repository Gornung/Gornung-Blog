<?php

declare(strict_types=1);

use Gornung\Webentwicklung\Http\Request;
use Gornung\Webentwicklung\Http\Response;
use Gornung\Webentwicklung\Http\ResponseInterface;
use Gornung\Webentwicklung\Router;
use Gornung\Webentwicklung\Controller\Blog as BlogController;

require dirname(__DIR__) . '/vendor/autoload.php';

$request = new Request();
$request->setUrl($_SERVER['REQUEST_URI']);
$request->setParameters($_REQUEST);

$response = new Response();
$router = new Router();
$blogController = new BlogController();


$router->addRoute('/blog/show', [BlogController::class, 'show']);


$router->route($request, $response);

http_response_code($response->getStatusCode());
echo $response->getBody();
