<?php

require 'vendor/autoload.php';

use Meek\Routing\RouteCollection;
use Meek\Routing\Router;
use Meek\Routing\HttpException;

// set the basepath like so, if your application is in a subfolder.
$path = substr($_SERVER['REQUEST_URI'], strlen('/meek-routing'));

$routes = new RouteCollection();

$routes->add('GET', '/', function () {
    return 'Hello, World!';
});

$routes->add('POST', '/login', function () {
    // do stuff with form here
});

// Working with named parameters.
$routes->add('GET', '/:username', function ($username) {
    return "Hello, $username!";
});

$router = new Router($routes);

try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], $path);
} catch (HttpException $e) {
    echo $e->getCode() . ' ' . $e->getMessage();
}
