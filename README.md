# LiteRT Mutex

[![Latest Stable Version](https://poser.pugx.org/litert/mutex/v/stable?format=flat-square)](https://packagist.org/packages/litert/mutex) [![License](https://poser.pugx.org/litert/mutex/license?format=flat-square)](https://packagist.org/packages/litert/mutex)

A mutex management library for LiteRT.

## Features

Supports mutex based on following drivers:

- FileSystem
- Redis ([PECL Extension](https://pecl.php.net/package/redis))
- Memcached ([PECL Extension](https://pecl.php.net/package/memcached))
- Memcache ([PECL Extension](https://pecl.php.net/package/memcache))
- APCu ([PECL Extension](https://pecl.php.net/package/apcu))

> Only the specific one PECL extension is required when you are using a
> driver.

## Installation

It's recommended to install by composer:

```sh
composer require litert/mutex
```

Or just git clone this repository, and put the **lib** directory into you 
project.

## Document

 - [简体中文版](./docs/zh-CN/index.md).

## License

This library is published under [Apache-2.0](./LICENSE) license.
