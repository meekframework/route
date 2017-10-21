# Meek-Routing Component

[![Scrutinizer Build Status][build-image]][build-url]
[![Scrutinizer Quality][code-quality-image]][code-quality-url]
[![Scrutinizer Coverage][code-coverage-image]][code-coverage-url]
[![Packagist Latest Stable Version][packagist-image]][packagist-url]
[![MIT License][license-image]][license-url]

A simple framework for routing.

## Installation

With [Composer](https://getcomposer.org/):

```bash
composer require meekframework/route
```

## Usage

Using the router with the front controller pattern is probably the common use:

```php
use Meek\Route\Collection;
use Meek\Route\Mapper;
use Meek\Route\Matcher;
use Meek\Route\Dispatcher;
use Zend\Diactoros\Response\TextResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;
use Meek\Route\TargetNotMatched;
use Meek\Route\MethodNotMatched;
use Psr\Http\Message\ServerRequestInterface;

// any PSR7 compliant library can be use to generate server requests
$serverRequest = ServerRequestFactory::fromGlobals();
$collection = new Collection();
$map = new Mapper($collection);
$matcher = new Matcher($collection);
$dispatcher = new Dispatcher($matcher);

$map->get('/', function (ServerRequestInterface $request) {
    // a PSR7 responses must be returned
    return new TextResponse('Hello, world!');
});

$map->get('/posts', function (ServerRequestInterface $request) {
    return new TextResponse('Viewing all posts!');
});

$map->get('/posts/:id', function (ServerRequestInterface $request) {
    return new TextResponse(sprintf('You are viewing post "%s"!', $request->getAttribute('id')));
});

// etc...
$map->head('/', function (ServerRequestInterface $request) { ... });
$map->put('/', function (ServerRequestInterface $request) { ... });
$map->post('/', function (ServerRequestInterface $request) { ... });
$map->delete('/', function (ServerRequestInterface $request) { ... });
$map->options('/', function (ServerRequestInterface $request) { ... });

try {
    $response = $dispatcher->dispatch($serverRequest);
} catch (TargetNotMatched $e) {
    $response = new TextResponse('Not Found', 404);
} catch (MethodNotMatched $e) {
    $response = new TextResponse('Method Not Allowed', 405, ['allow' => $e->getAllowedMethods()]);
}

(new SapiEmitter())->emit($response);
```

## API

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md).

## Credits/Authors

## License

The MIT License (MIT). Please see [LICENSE.md](LICENSE.md) for more information.

[build-url]: https://scrutinizer-ci.com/g/meekframework/meek-route/build-status/master
[build-image]: https://scrutinizer-ci.com/g/meekframework/meek-route/badges/build.png?b=master
[code-quality-url]: https://scrutinizer-ci.com/g/meekframework/meek-route/?branch=master
[code-quality-image]: https://img.shields.io/scrutinizer/g/meekframework/meek-route.svg
[code-coverage-url]: https://scrutinizer-ci.com/g/meekframework/meek-route
[code-coverage-image]: https://scrutinizer-ci.com/g/meekframework/meek-route/badges/coverage.png?b=master
[packagist-url]: https://packagist.org/packages/meekframework/meek-route
[packagist-image]: https://img.shields.io/packagist/v/meekframework/meek-route.svg
[license-url]: https://github.com/meekframework/meek-route/blob/master/LICENSE.md
[license-image]: https://img.shields.io/packagist/l/meekframework/meek-route.svg
