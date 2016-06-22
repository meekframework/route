# Meek-Routing Component

[![Scrutinizer Build Status][build-image]][build-url]
[![Scrutinizer Quality][code-quality-image]][code-quality-url]
[![Scrutinizer Coverage][code-coverage-image]][code-coverage-url]
[![Packagist Latest Stable Version][packagist-image]][packagist-url]
[![MIT License][license-image]][license-url]
[![composer.lock Status][composer-lock-image]][composer-lock-url]

A simple framework for routing.

## Install

with [Composer](https://getcomposer.org/):

```bash
composer require nbish11/meek-routing
```

## Usage

Using the router as a proxy will probably be the most common usage:

```php
<?php
// bootstrapping...
error_reporting(-1);
date_default_timezone_set('Australia/Brisbane');

require_once 'vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface;
use Meek\Routing\Rule\MatchMethod;

// setup...
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals();
$router = Meek\Routing\Router::create();

// adding `Route` objects manually.
$router->add(new Meek\Routing\Route(
    'api.users.retrieve',
    '/api/:version/users/:id',
    function (ServerRequestInterface $request) {
        return sprintf(
            'retrieving... %s... %s...',
            $request->getAttribute('version'),
            $request->getAttribute('id')
        );
    }
));

// using built-in rules.
$router->delete('/users/:id', function (ServerRequestInterface $request) {
    return sprintf('Deleting user: "%s"', $request->getAttribute('id'));
})->addRule(new MatchMethod());

// custom rules
$router->get('/admin', function (ServerRequestInterface $request) {
    return 'Admin Section...';
})->addRule(function () {
    // authentication logic goes here
});

// catch all route (without method matching).
$router->map('vanity', '/:username', function (ServerRequestInterface $request) {
    return sprintf('Hello, %s!', $request->getAttribute('username'));
});

$router->dispatch($request);
```

## Testing

This project uses [PHPUnit](https://phpunit.de/) for assertions and [Zend\Diactoros](https://zendframework.github.io/zend-diactoros/) for mocking incoming requests, and such. To run unit tests simply run the following command:

```bash
composer test
```

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md).

## License

The MIT License (MIT). Please see [LICENSE.md](LICENSE.md) for more information.

[build-url]: https://scrutinizer-ci.com/g/nbish11/meek-routing/build-status/master
[build-image]: https://scrutinizer-ci.com/g/nbish11/meek-routing/badges/build.png?b=master
[code-quality-url]: https://scrutinizer-ci.com/g/nbish11/meek-routing/?branch=master
[code-quality-image]: https://img.shields.io/scrutinizer/g/nbish11/meek-routing.svg
[code-coverage-url]: https://scrutinizer-ci.com/g/nbish11/meek-routing
[code-coverage-image]: https://scrutinizer-ci.com/g/nbish11/meek-routing/badges/coverage.png?b=master
[packagist-url]: https://packagist.org/packages/nbish11/meek-routing
[packagist-image]: https://img.shields.io/packagist/v/nbish11/meek-routing.svg
[license-url]: https://github.com/nbish11/meek-routing/blob/master/LICENSE.md
[license-image]: https://img.shields.io/packagist/l/nbish11/meek-routing.svg
[composer-lock-url]: https://packagist.org/packages/nbish11/meek-routing
[composer-lock-image]: https://poser.pugx.org/nbish11/meek-routing/composerlock
