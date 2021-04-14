<?php

declare(strict_types=1);

use Gornung\Webentwicklung\Request;
use Gornung\Webentwicklung\Response;

require __DIR__ . '/../vendor/autoload.php';

$urlPath = $_SERVER['REQUEST_URI'];

if (strpos(strtolower($urlPath), 'hello')) {
    $personToGreet = 'Stranger';
    if (isset($_REQUEST['name'])) {
        $personToGreet = $_REQUEST['name'];
    }
    echo 'Hello ' . $personToGreet;
} else {
    echo 'Hello there!';
}
