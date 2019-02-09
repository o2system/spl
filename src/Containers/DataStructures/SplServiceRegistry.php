<?php
/**
 * This file is part of the O2System Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author         Steeve Andrian Salim
 * @copyright      Copyright (c) Steeve Andrian Salim
 */

// ------------------------------------------------------------------------

namespace O2System\Spl\Containers\DataStructures;

// ------------------------------------------------------------------------

use O2System\Spl\Info\SplClassInfo;

/**
 * Class SplServiceRegistry
 *
 * @package O2System\Spl\Containers\DataStructures
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
            if (null !== ($constructor = $this->getConstructor())) {
                $args = func_get_args();

                if (count($args)) {
                    $this->instance = $this->newInstance();
                } else {
                    $this->instance = $this->newInstanceArgs(func_get_args());
                }
            } else {
                $this->instance = $this->newInstanceWithoutConstructor();
            }
        }

        return $this->instance;
    }
}