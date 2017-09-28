# LiteRT/Mutex 文档

> [返回目录](./index.md)

## 概述

Mutex 是一个为 LiteRT 框架实现的简单互斥锁管理库。可以用于跨线程、进程、会话、服务器
的锁机制。

## 功能

目前 LiteRT/Mutex 库支持如下类型的互斥锁：

- 文件系统
- Redis ([PECL Extension](https://pecl.php.net/package/redis))
- Memcached ([PECL Extension](https://pecl.php.net/package/memcached))
- Memcache ([PECL Extension](https://pecl.php.net/package/memcache))
- APCu ([PECL Extension](https://pecl.php.net/package/apcu))

> 并非以上所有 PECL 扩展都要安装。只有在用到其中一种互斥锁的时候，才需要安装对应的
PECL 扩展。

## 安装

推荐通过 composer 安装

```sh
composer require litert/mutex
```

也可以直接通过 git clone 或者下载 zip/tgz 包使用。

> [下一章：使用文件互斥锁](./01-use-file-mutex.md) | [返回目录](./index.md)
