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

class APCuMutex extends AbstractMutex implements IMutex
{
    /**
     * @var bool
     */
    protected $_locked;

    /**
     * @var string
     */
    protected $_prefix;

    /**
     * @var int
     */
    protected $_lockTime;

    /**
     * @var int
     */
    protected $_ttl;

    /**
     * @var int
     */
    protected $_retryInterval;

    public function __construct(string $name, array $opts)
    {
        parent::__construct($name, $opts);

        $this->_locked = false;
        $this->_prefix = $opts['prefix'] ?? '';
        $this->_ttl = $opts['ttl'] ?? 0;
        $this->_retryInterval = $opts['retryInterval'] ?? 1;
    }

    public function lock(): bool
    {
        if ($this->isLocked()) {

            return true;
        }

        $key = "{$this->_prefix}{$this->_name}";

        $this->_lockTime = (int)(microtime(true) * 10000);

        while (!apcu_add($key, $this->_lockTime, $this->_ttl)) {

            usleep($this->_retryInterval);

            $this->_lockTime = (int)(microtime(true) * 10000);
        }

        return $this->_locked = true;
    }

    public function tryLock(): bool
    {
        if ($this->isLocked()) {

            return true;
        }

        $this->_lockTime = (int)(microtime(true) * 10000);

        return $this->_locked = apcu_add(
            "{$this->_prefix}{$this->_name}",
            $this->_lockTime,
            $this->_ttl
        );
    }

    public function unlock()
    {
        if ($this->isLocked()) {

            apcu_delete("{$this->_prefix}{$this->_name}");
            $this->_locked = false;
        }
    }

    public function isLocked(): bool
    {
        if ($this->_locked) {

            if ($this->_ttl) {

                return apcu_cas(
                    "{$this->_prefix}{$this->_name}",
                    $this->_lockTime,
                    $this->_lockTime
                );
            }

            return true;
        }

        return false;
    }
}