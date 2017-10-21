<?php
// bootstrapping...
error_reporting(-1);
date_default_timezone_set('Australia/Brisbane');
require_once __DIR__ . '/../vendor/autoload.php';


use Meek\Route\Collection;
use Meek\Route\Mapper;
use Meek\Route\Matcher;
use Meek\Route\Dispatcher;
use Zend\Diactoros\Response\TextResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;
use Meek\Route\TargetNotMatched;
use Meek\Route\MethodNotMatched;

$serverRequest = ServerRequestFactory::fromGlobals();
$collection = new Collection();
$map = new Mapper($collection);
$matcher = new Matcher($collection);
$dispatcher = new Dispatcher($matcher);

$map->get('/', function () {
    return new TextResponse('Hello, world!');
});

$map->get('/posts', function () {
    return new TextResponse('Viewing all posts!');
});

$map->get('/posts/:id', function ($request) {
    return new TextResponse('You are viewing post "' . $request->getAttribute('id') . '"!');
});

try {
    $response = $dispatcher->dispatch($serverRequest);
} catch (TargetNotMatched $e) {
    $response = new TextResponse('Not Found', 404);
} catch (MethodNotMatched $e) {
    $response = new TextResponse('Method Not Allowed', 405, ['allow' => $e->getAllowedMethods()]);
}

(new SapiEmitter())->emit($response);
