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

interface IMutex
{
    public function __construct(
        string $name,
        array $opts
    );

    /**
     * Try to lock up, and if the mutex is locked by another thread,
     * current thread will be hang up (blocking), until another thread
     * release the mutex.
     *
     * @return bool
     *   Returns true if locked successfully. Otherwise, false will be
     * returned.
     */
    public function lock(): bool;

    /**
     * Try to lock up, and if the mutex is locked by another thread,
     * current thread will be hang up (blocking), until another thread
     * release the mutex.
     *
     * @return bool
     */
    public function tryLock(): bool;

    /**
     * Release a mutex locked by current thread.
     *
     * @return mixed
     */
    public function unlock();

    /**
     * Tell if this mutex is locked and is locked by current thread.
     *
     * @return bool
     */
    public function isLocked(): bool;
}
