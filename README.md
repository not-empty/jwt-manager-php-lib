# JWT Manager PHP

[![Latest Version](https://img.shields.io/github/v/release/not-empty/jwt-manager-php-lib.svg?style=flat-square)](https://github.com/not-empty/jwt-manager-php-lib/releases)
[![codecov](https://codecov.io/gh/not-empty/jwt-manager-php-lib/graph/badge.svg?token=AEMV163UW6)](https://codecov.io/gh/not-empty/jwt-manager-php-lib)
[![CI Build](https://img.shields.io/github/actions/workflow/status/not-empty/jwt-manager-php-lib/php.yml)](https://github.com/not-empty/jwt-manager-php-lib/actions/workflows/php.yml)
[![Downloads Old](https://img.shields.io/packagist/dt/kiwfy/jwt-manager-php?logo=old&label=downloads%20legacy)](https://packagist.org/packages/kiwfy/jwt-manager-php)
[![Downloads](https://img.shields.io/packagist/dt/not-empty/jwt-manager-php-lib?logo=old&label=downloads&v2)](https://packagist.org/packages/not-empty/jwt-manager-php-lib)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)](http://makeapullrequest.com)
[![Packagist License (custom server)](https://img.shields.io/packagist/l/not-empty/jwt-manager-php-lib?v2)](https://github.com/not-empty/jwt-manager-php-lib/blob/master/LICENSE)

PHP library to manage JWT authentication

### Installation

[Release 6.0.0](https://github.com/not-empty/jwt-manager-php-lib/releases/tag/6.0.0) Requires [PHP](https://php.net) 8.2

[Release 5.0.0](https://github.com/not-empty/jwt-manager-php-lib/releases/tag/5.0.0) Requires [PHP](https://php.net) 8.1

[Release 4.0.0](https://github.com/not-empty/jwt-manager-php-lib/releases/tag/4.0.0) Requires [PHP](https://php.net) 7.4

[Release 3.0.0](https://github.com/not-empty/jwt-manager-php-lib/releases/tag/3.0.0) Requires [PHP](https://php.net) 7.3

[Release 2.0.0](https://github.com/not-empty/jwt-manager-php-lib/releases/tag/2.0.0) Requires [PHP](https://php.net) 7.2

[Release 1.0.0](https://github.com/not-empty/jwt-manager-php-lib/releases/tag/1.0.0) Requires [PHP](https://php.net) 7.1

The recommended way to install is through [Composer](https://getcomposer.org/).

```sh
composer require not-empty/jwt-manager-php-lib
```

### Usage

Generating a token

```php
use JwtManager\JwtManager;
$secret = '77682b9441bb7daa7a1fa6eb7522b689';
$context = 'test';
$expire = 30;
$renew = 10;
$jwtManager = new JwtManager(
    $secret,
    $context,
    $expire,
    $renew
);
$tokenGenerated = $jwtManager->generate('test');
var_dump($tokenGenerated);
```

Dedoce the token and return the data

```php
$result = $jwtManager->decodePayload($tokenGenerated);
var_dump($result);
```

Verify if token is valid

```php
$result = $jwtManager->isValid($tokenGenerated);
var_dump($result);
```

Check if a token is on time

```php
$result = $jwtManager->isOnTime($tokenGenerated);
var_dump($result);
```

Get the expiration time of a token

```php
$result = $jwtManager->getexpire($tokenGenerated);
var_dump($result);
```

Check if need to refresh a token

```php
$result = $jwtManager->tokenNeedToRefresh($tokenGenerated);
var_dump($result);
```

if you want an environment to run or test it, you can build and install dependences like this

```sh
docker build --build-arg PHP_VERSION=8.2-cli -t not-empty/jwt-manager-php-lib:php82 -f contrib/Dockerfile .
```

Access the container
```sh
docker run -v ${PWD}/:/var/www/html -it not-empty/jwt-manager-php-lib:php82 bash
```

Verify if all dependencies is installed
```sh
composer install --no-dev --prefer-dist
```

and run
```sh
php sample/jwt-manager-sample.php
```

### Development

Want to contribute? Great!

The project using a simple code.
Make a change in your file and be careful with your updates!
**Any new code will only be accepted with all validations.**

To ensure that the entire project is fine:

First you need to building a correct environment to install all dependences

```sh
docker build --build-arg PHP_VERSION=8.2-cli -t not-empty/jwt-manager-php-lib:php82 -f contrib/Dockerfile .
```

Access the container
```sh
docker run -v ${PWD}/:/var/www/html -it not-empty/jwt-manager-php-lib:php82 bash
```

Install all dependences
```sh
composer install --dev --prefer-dist
```

Run all validations
```sh
composer check
```

**Not Empty Foundation - Free codes, full minds**
