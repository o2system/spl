<?php
/**
 * This file is part of the O2System PHP Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author         Steeve Andrian Salim
 * @copyright      Copyright (c) Steeve Andrian Salim
 */

// ------------------------------------------------------------------------

namespace O2System\Spl\Containers\Datastructures;

// ------------------------------------------------------------------------

use O2System\Spl\Info\SplClassInfo;

/**
 * Class SplServiceRegistry
 *
 * @package O2System\Spl\Containers\Datastructures
 */
class SplServiceRegistry extends SplClassInfo
{
    /**
     * Service Singleton Instance
     *
     * @var object
     */
    private $instance;

    public function __construct($service)
    {
        if (is_object($service)) {
            $this->instance = $service;
            $service = get_class($service);
        }

        parent::__construct($service);
    }

    public function getClassName()
    {
        return get_class_name($this->name);
    }

    public function &getInstance()
    {
        if (empty($this->instance)) {
            $this->instance = $this->newInstance(func_get_args());
        }

        return $this->instance;
    }
}