# 使用缓存互斥锁

> [上一章：使用文件互斥锁](./01-use-file-mutex.md) | [返回目录](./index.md)

## 0. 概述

上一章中说过，Mutex 库中的互斥锁分为两大类，现在来看看缓存互斥锁。

缓存互斥锁是基于 Key-value 缓存系统中原子操作的互斥锁，适用于跨服务器、跨系统、跨会话
等场景。目前 Mutex 支持基于 Memcache、Memcached、APCu、Redis 四种 PECL 扩展的缓存
互斥锁。

> 由于缓存互斥锁基于对应缓存系统的 PECL 扩展实现，因此使用前应当安装对应的 PECL 扩展

本章节以 Redis 为例，介绍如何使用缓存互斥锁。

> 创建方式和互斥锁对象工厂等和文件锁工厂基本一致，此处不再赘述，更多细节请阅读
《[API 文档](./03-api-references.md)》中的相关内容。

## 1. 基本使用

（除了 APCu 之外）使用缓存互斥锁必须传递一个缓存客户端对象作为 $opts 的 client 字段，
例如：

```php
<?php
declare (strict_types = 1);

require 'vendor/autoload.php';

$factory = \L\Mutex\Factory::createRedisFactory([
    'client' => (function() {

        // 创建 Redis 客户端对象

        $client = new \Redis();

        $client->connect('127.0.0.1', 6379);

        return $client;
    })()
]);

$lock1 = $factory->create('hello');
$lock2 = $factory->create('hello');

if ($lock1->lock()) {

    echo 'Lock1: locked.', PHP_EOL;
}
else {

    echo 'Lock1: failed.', PHP_EOL;
}

if ($lock2->tryLock()) {

    $lock2->unlock();
    echo 'Lock2: locked.', PHP_EOL;
}
else {

    echo 'Lock2: failed.', PHP_EOL;
}

if ($lock1->isLocked()) {

    $lock1->unlock();
}


if ($lock2->tryLock()) {

    echo 'Lock2: locked.', PHP_EOL;
    $lock2->unlock();
}
else {

    echo 'Lock2: failed.', PHP_EOL;
}
```

## 2. 使用超时自动解锁的互斥锁

现代缓存系统基本都支持缓存对象的 TTL，因此可以借此实现互斥锁的超时自动解锁。

只需要在创建互斥锁对象时给 $opts 参数增加一个 ttl 字段即可。

```php
<?php
declare (strict_types=1);

require 'vendor/autoload.php';

$factory = \L\Mutex\Factory::createRedisFactory([
    'ttl' => 3, // 互斥锁对象在创建 3 秒后失效。
    'client' => (function() {
        $client = new \Redis();

        $client->connect('127.0.0.1', 6379);

        return $client;
    })()
]);

$lock1 = $factory->create('hello.lck');
$lock2 = $factory->create('hello.lck');

if ($lock1->lock()) {

    echo 'Lock1: locked.', PHP_EOL;
}
else {

    echo 'Lock1: failed.', PHP_EOL;
}

/**
 * 由于 $lock1 锁定了 hello.lck，于是此处必须等待 $lock1 失效（自动解锁）
 * 才能成功锁定并继续。
 */
if ($lock2->lock()) {

    $lock2->unlock();
    echo 'Lock2: locked.', PHP_EOL;
}
else {

    echo 'Lock2: failed.', PHP_EOL;
}

if ($lock1->tryLock()) {

    echo 'Lock1: locked.', PHP_EOL;
}
else {

    echo 'Lock1: failed.', PHP_EOL;
}

if ($lock2->tryLock()) {

    echo 'Lock2: locked.', PHP_EOL;
    $lock2->unlock();
}
else {

    echo 'Lock2: failed.', PHP_EOL;
}

$lock1->unlock();

```

## 3. 更多用法

更多详细的用法请看下一章 API 文档。

> [下一章：API 文档](./03-api-references.md) | [返回目录](./index.md)
