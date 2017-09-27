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

class FileMutex extends AbstractMutex implements IMutex
{
    /**
     * @var bool|resource
     */
    protected $_fd;

    public function __construct(string $name, array $opts)
    {
        parent::__construct($name, $opts);
        $this->_fd = false;
    }

    public function lock(): bool
    {
        if ($this->isLocked()) {
            return true;
        }

        $this->_fd = fopen(
            $this->_name,
            'w'
        );

        if ($this->_fd === false) {

            return false;
        }

        if (!flock($this->_fd, LOCK_EX)) {
            fclose($this->_fd);
            return false;
        }

        return true;
    }

    public function tryLock(): bool
    {
        if ($this->isLocked()) {
            return true;
        }

        $this->_fd = fopen(
            $this->_name,
            'w'
        );

        if ($this->_fd === false) {

            return false;
        }

        if (!flock($this->_fd, LOCK_EX | LOCK_NB)) {
            fclose($this->_fd);
            $this->_fd = false;
            return false;
        }

        return true;
    }

    public function unlock()
    {
        if ($this->isLocked()) {

            flock($this->_fd, LOCK_UN);
            fclose($this->_fd);
            $this->_fd = false;
        }
    }

    public function isLocked(): bool
    {
        return $this->_fd !== false;
    }
}