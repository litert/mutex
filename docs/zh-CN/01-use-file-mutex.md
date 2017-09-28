# 使用文件互斥锁

> [返回目录](./index.md)

## 0. 概述

LiteRT\Mutex 库中，互斥锁分两大类，一是基于文件系统的文件互斥锁，另一类是基于
Key-value 缓存系统中原子操作的缓存互斥锁。

文件互斥锁适用于单一主机环境下的跨线程、跨进程的资源锁定。

## 1. 快捷创建互斥锁

```php
<?php
declare (strict_types = 1);

// 通过 composer autoloader 引入 LiteRT/Mutex。

require 'vendor/autoload.php';

// 创建两个同名互斥锁

$mutex1 = \L\Mutex\Factory::createFileMutex(
    'test.lck'
);

$mutex2 = \L\Mutex\Factory::createFileMutex(
    'test.lck'
);

/**
 * 尝试锁定 $mutex1。
 *
 * lock 方法是阻塞的，如果名为 test.lck 的互斥锁已经被锁定，则
 * 该方法会一直等到 test.lck 互斥锁被解锁，并重新被 $mutex1 锁定
 * 才会返回。
 */
if ($mutex1->lock()) {

    echo 'Mutex 1 is locked.', PHP_EOL;

    /**
     * 在 $mutex1 被锁定的基础上尝试锁定 $mutex2
     *
     * tryLock 和 lock 的唯一区别是， tryLock 方法是非阻塞的。
     */
    if ($mutex2->tryLock()) {

        echo 'Mutex 2 is locked.', PHP_EOL;
    }
    else {

        echo 'Failed to lock mutex 2.', PHP_EOL;
    }

    /**
     * unlock 方法用于释放一个互斥锁。
     *
     * 注：只能解锁被当前对象锁定的互斥锁。
     */
    $mutex1->unlock();
}
else { // 对于文件锁，只有在文件无法创建或打开时会返回错误。

    echo 'Failed to lock mutex 1.', PHP_EOL;
}

if ($mutex2->lock()) {

    echo 'Mutex 2 is locked.', PHP_EOL;
    $mutex2->unlock();
}
else {

    echo 'Failed to lock mutex 2.', PHP_EOL;
}
```

## 2. 使用自动释放的文件互斥锁

`\L\Mutex\Factory::createFileLock` 方法的第二个参数 $opts 是一个数组，可以将一些配置
参数通过 $opts 参数传递给锁对象，比如通用的参数 `autoUnlock` 就是用于允许一个被锁定的
互斥锁对象在析构的时候自动解除锁定。

```php
<?php
declare (strict_types=1);

require __DIR__ . 'vendor/autoload.php';

$lock = \L\Mutex\Factory::createFileMutex(
    'hello.lck',
    [
        # 'path' => './locks/', // 还可以设置 path 来指定锁文件的存放路径。
        'autoUnlock' => true // 使 $lock 对象在析构时自动解锁。
    ]
);

$lock2 = \L\Mutex\Factory::createFileMutex('hello.lck');

if ($lock->lock()) {

    echo 'Lock1: locked.', PHP_EOL;
}
else {

    echo 'Lock1: failed.', PHP_EOL;
}

if ($lock2->tryLock()) {

    echo 'Lock2: locked.', PHP_EOL;
}
else {

    echo 'Lock2: failed.', PHP_EOL;
}

unset($lock);
# $lock->unlock(); // 此处直接释放锁定的对象 $lock，而不调用它的 unlock 方法。

if ($lock2->tryLock()) { // 锁定成功，说明 $lock 已经被解锁了。

    echo 'Lock2: locked.', PHP_EOL;
}
else {

    echo 'Lock2: failed.', PHP_EOL;
}

$lock2->unlock();

```

## 3. 使用统一配置的互斥锁工厂对象

如果每次创建互斥锁对象都要传递相同的 $opts 参数，无疑是很浪费时间和耐心的，于是
可以通过创建适配单一 $opts 的工厂对象来快速创建居然相同 $opts 参数的互斥锁对象。

```php

declare (strict_types=1);

require __DIR__ . 'vendor/autoload.php';

$factory = \L\Mutex\Factory::createFileFactory([
    'autoUnlock' => true // 使 $lock 对象在析构时自动解锁。
]);

/**
 * 此处创建的 $lock1 和 $lock2 都具有 autoUnlock 特性。
 */

$lock1 = $factory->create('test-factory.lck');
$lock2 = $factory->create('test-factory.lck');

/**
 * $lock3 在 autoUnlock 的基础上，还增加了 path 属性。
 */

$lock3 = $factory->createEx(
    'test-factory.lck', [
        'path' => './locks/'
    ]
);
```

> [下一章：使用缓存互斥锁](./02-use-cache-mutex.md) | [返回目录](./index.md)
