# Meek-Routing Component

[![Scrutinizer Build Status][scrutinizer-build-image]][scrutinizer-build-url]
[![Scrutinizer Code Quality][scrutinizer-code-quality-image]][scrutinizer-code-quality-url]
[![Scrutinizer Code Coverage][scrutinizer-code-coverage-image]][scrutinizer-code-coverage-url]
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

[scrutinizer-build-url]: https://scrutinizer-ci.com/g/meekframework/route/build-status/master
[scrutinizer-build-image]: https://scrutinizer-ci.com/g/meekframework/route/badges/build.png?b=master
[scrutinizer-code-quality-url]: https://scrutinizer-ci.com/g/meekframework/route/?branch=master
[scrutinizer-code-quality-image]: https://scrutinizer-ci.com/g/meekframework/route/badges/quality-score.png?b=master
[scrutinizer-code-coverage-url]: https://scrutinizer-ci.com/g/meekframework/route/?branch=master
[scrutinizer-code-coverage-image]: https://scrutinizer-ci.com/g/meekframework/route/badges/coverage.png?b=master
[packagist-url]: https://packagist.org/packages/meekframework/route
[packagist-image]: https://img.shields.io/packagist/v/meekframework/route.svg
[license-url]: https://raw.githubusercontent.com/meekframework/route/master/LICENSE.md
[license-image]: https://img.shields.io/badge/license-MIT-blue.svg
