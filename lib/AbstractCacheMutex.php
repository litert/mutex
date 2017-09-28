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

abstract class AbstractCacheMutex extends AbstractMutex implements IMutex
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

    protected $_mc;

    public function __construct(string $name, array $opts)
    {
        parent::__construct($name, $opts);

        $this->_locked = false;
        $this->_mc = $opts['client'];
        $this->_prefix = $opts['prefix'] ?? '';
        $this->_ttl = $opts['ttl'] ?? 0;
        $this->_retryInterval = $opts['retryInterval'] ?? 1;
    }
}
