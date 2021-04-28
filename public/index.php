<?php

declare(strict_types=1);

use Gornung\Webentwicklung\Http\Request;
use Gornung\Webentwicklung\Http\Response;
use Gornung\Webentwicklung\Router;
use Gornung\Webentwicklung\Controller\IController;
use Gornung\Webentwicklung\

require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$request = new Request();
$request->setUrl($_SERVER['REQUEST_URI']);
$request->setParameters($_REQUEST);

$response = new Response();

$blogController = new BlogController();

$router = new Router();
$router->addRoute('/blog/show', [$blogController, 'show']);


$router->route($request, $response);

http_response_code($response->getStatusCode());
echo $response->getBody();
