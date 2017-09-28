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

abstract class IFactory
{
    /**
     * @var array
     */
    protected $_opts;

    /**
     * IFactory constructor.
     *
     * @param array $opts The options of new lock objects.
     */
    public function __construct(array $opts)
    {
        $this->_opts = $opts;
    }

    protected function _fillOptions(array $opts): array
    {
        foreach ($this->_opts as $key => $val) {

            if (empty($opts[$key])) {

                $opts[$key] = $val;
            }
        }

        return $opts;
    }

    /**
     * Create a new lock object.
     *
     * > Tips: use the options for new lock determined in constructor.
     *
     * @param string $name The name of new lock object.
     *
     * @return IMutex
     */
    abstract public function create(string $name): IMutex;

    /**
     * Create a new lock object with custom options.
     *
     * @param string $name The name of new lock object.
     * @param array $opts The options of new lock object.
     *
     * @return IMutex
     */
    abstract public function createEx(
        string $name,
        array $opts
    ): IMutex;
}
