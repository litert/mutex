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

/**
 * Class MemcacheMutex
 * @package L\Mutex
 *
 * @property \Memcache $_mc
 */
class MemcacheMutex extends AbstractCacheMutex implements IMutex
{
    public function lock(): bool
    {
        if ($this->isLocked()) {

            return true;
        }

        $key = "{$this->_prefix}{$this->_name}";

        do {

            $this->_lockTime = (string)microtime(true);

            $result = $this->_mc->add(
                $key,
                $this->_lockTime,
                0,
                $this->_ttl
            );

            if ($result) {

                break;
            }

            usleep($this->_retryInterval);

        } while (1);

        return $this->_locked = true;
    }

    public function tryLock(): bool
    {
        if ($this->isLocked()) {

            return true;
        }

        $this->_lockTime = (string)microtime(true);

        return $this->_locked = $this->_mc->add(
            "{$this->_prefix}{$this->_name}",
            $this->_lockTime,
            0,
            $this->_ttl
        );
    }

    public function unlock()
    {
        if ($this->isLocked()) {

            $this->_mc->delete("{$this->_prefix}{$this->_name}");
            $this->_locked = false;
        }
    }

    public function isLocked(): bool
    {
        if ($this->_locked) {

            if ($this->_ttl) {

                return $this->_locked = ($this->_mc->get(
                    "{$this->_prefix}{$this->_name}"
                ) === $this->_lockTime);
            }

            return true;
        }

        return false;
    }
}
