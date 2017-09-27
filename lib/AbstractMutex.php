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

abstract class AbstractMutex implements IMutex
{
    /**
     * @var string
     */
    protected $_name;

    /**
     * @var bool
     */
    protected $_autoUnlock;

    public function __construct(string $name, array $opts)
    {
        $this->_name = $name;
        $this->_autoUnlock = $opts['autoUnlock'] ?? false;
    }

    public function __destruct()
    {
        $this->_autoUnlock && $this->unlock();
    }

    abstract public function lock(): bool;

    abstract public function tryLock(): bool;

    abstract public function unlock();

    abstract public function isLocked(): bool;
}
