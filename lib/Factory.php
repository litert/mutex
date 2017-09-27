<?php
/*
   +----------------------------------------------------------------------+
   | LiteRT Mutex Library                                                 |
   +----------------------------------------------------------------------+
   | Copyright (c) 2007-2017 Fenying Studio                               |
   +----------------------------------------------------------------------+
   | This source file is subject to version 2.0 of the Apache license,    |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | https://github.com/litert/mutex/blob/master/LICENSE                  |
   +----------------------------------------------------------------------+
   | Authors: Angus Fenying <i.am.x.fenying@gmail.com>                    |
   +----------------------------------------------------------------------+
 */

declare (strict_types=1);

namespace L\Mutex;

class Factory
{
    /**
     * Create a mutex object using driver File
     *
     * @param string $lockName  The name of lock.
     * @param array $opts       The options of lock.
     *
     * @return IMutex
     */
    public static function createFileMutex(
        string $lockName,
        array $opts = []
    ): IMutex
    {
        return new FileMutex($lockName, $opts);
    }

    /**
     * Create a mutex factory using driver File
     *
     * @param array $opts       The options of new mutex created by factory.
     *
     * @return IFactory
     */
    public static function createFileFactory(array $opts = []): IFactory
    {
        return new FileFactory($opts);
    }

    /**
     * Create a mutex object using driver APCu.
     *
     * > **Tips: Requiring the PECL APCu extension.**
     * >
     * > Download: https://pecl.php.net/package/apcu
     *
     * @param string $lockName  The name of lock.
     * @param array $opts       The options of lock.
     *
     * @return IMutex
     */
    public static function createAPCuMutex(
        string $lockName,
        array $opts = []
    ): IMutex
    {
        return new APCuMutex($lockName, $opts);
    }

    /**
     * Create a mutex factory using driver APCu
     *
     * > **Tips: Requiring the PECL APCu extension.**
     * >
     * > Download: https://pecl.php.net/package/apcu
     *
     * @param array $opts       The options of new mutex created by factory.
     *
     * @return IFactory
     */
    public static function createAPCuFactory(array $opts = []): IFactory
    {
        return new APCuFactory($opts);
    }

    /**
     * Create a mutex object using driver Memcache.
     *
     * > **Tips: Requiring the PECL Memcache extension.**
     * >
     * > Download: https://pecl.php.net/package/memcache
     *
     * @param string $lockName  The name of lock.
     * @param array $opts       The options of lock.
     *
     * @return IMutex
     */
    public static function createMemcacheMutex(
        string $lockName,
        array $opts = []
    ): IMutex
    {
        return new MemcacheMutex($lockName, $opts);
    }

    /**
     * Create a mutex factory using driver Memcache
     *
     * > **Tips: Requiring the PECL Memcache extension.**
     * >
     * > Download: https://pecl.php.net/package/memcache
     *
     * @param array $opts       The options of new mutex created by factory.
     *
     * @return IFactory
     */
    public static function createMemcacheFactory(array $opts = []): IFactory
    {
        return new MemcacheFactory($opts);
    }

    /**
     * Create a mutex object using driver Memcached.
     *
     * > **Tips: Requiring the PECL Memcached extension.**
     * >
     * > Download: https://pecl.php.net/package/memcached
     *
     * @param string $lockName  The name of lock.
     * @param array $opts       The options of lock.
     *
     * @return IMutex
     */
    public static function createMemcachedMutex(
        string $lockName,
        array $opts = []
    ): IMutex
    {
        return new MemcachedMutex($lockName, $opts);
    }

    /**
     * Create a mutex factory using driver Memcached
     *
     * > **Tips: Requiring the PECL Memcached extension.**
     * >
     * > Download: https://pecl.php.net/package/memcached
     *
     * @param array $opts       The options of new mutex created by factory.
     *
     * @return IFactory
     */
    public static function createMemcachedFactory(array $opts = []): IFactory
    {
        return new MemcachedFactory($opts);
    }

    /**
     * Create a mutex object using driver Redis.
     *
     * > **Tips: Requiring the PECL Redis extension.**
     * >
     * > Download: https://pecl.php.net/package/redis
     *
     * @param string $lockName  The name of lock.
     * @param array $opts       The options of lock.
     *
     * @return IMutex
     */
    public static function createRedisMutex(
        string $lockName,
        array $opts = []
    ): IMutex
    {
        return new RedisMutex($lockName, $opts);
    }

    /**
     * Create a mutex factory using driver Redis
     *
     * > **Tips: Requiring the PECL Redis extension.**
     * >
     * > Download: https://pecl.php.net/package/redis
     *
     * @param array $opts       The options of new mutex created by factory.
     *
     * @return IFactory
     */
    public static function createRedisFactory(array $opts = []): IFactory
    {
        return new RedisFactory($opts);
    }
}
