<?php

declare(strict_types=1);

use Gornung\Webentwicklung\Http\Request;
use Gornung\Webentwicklung\Http\RequestInterface;
use Gornung\Webentwicklung\Http\Response;
use Gornung\Webentwicklung\Http\ResponseInterface;
use Gornung\Webentwicklung\Router;

require dirname(__DIR__) . '/vendor/autoload.php';

$request = new Request();
$request->setUrl($_SERVER['REQUEST_URI']);
$request->setParameters($_REQUEST);

$response = new Response();

$router = new Router();

$router->addRoute(
    '/hello',
    function (RequestInterface $request, ResponseInterface $response) {
        $personToGreet = 'stranger';
        if ($request->hasParameter('name')) {
            $personToGreet = $request->getParameter('name');
        }
        $response->setBody('Hello there ' . $personToGreet);
    }
);

$router->addRoute(
  '/info',
  function (ResponseInterface $request, ResponseInterface $response) {
      phpinfo();
  }
);

$router->route($request, $response);

http_response_code($response->getStatusCode());
echo $response->getBody();
