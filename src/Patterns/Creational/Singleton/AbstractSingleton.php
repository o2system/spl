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

namespace O2System\Spl\Patterns\Creational\Singleton;

/**
 * Class AbstractSingleton
 * @package O2System\Spl\Patterns\Creational\Singleton
 */
class AbstractSingleton implements InstanceInterface
{
    /**
     * AbstractSingleton::$instance
     *
     * Singleton Instance
     *
     * @var static
     */
    protected static $instance;

    // ------------------------------------------------------------------------

    /**
     * AbstractSingleton::__construct
     *
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
        static::$instance =& $this;
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractSingleton::getInstance
     *
     * Returns the *Singleton* instance of this class.
     *
     * @return static Returns the instance class
     */
    public static function getInstance()
    {
        if (empty(static::$instance)) {
            $className = get_called_class();

            static::$instance = new $className();

            if (method_exists(static::$instance, '__reconstruct')) {
                call_user_func_array([&static::$instance, '__reconstruct'], func_get_args());
            }
        }

        return static::$instance;
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractSingleton::__clone
     *
     * Application of __clone magic method with private visibility to prevent cloning of
     * the *Singleton* instance.
     *
     * @return void
     */
    protected function __clone()
    {
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractSingleton::__wakeup
     *
     * Application of __wakeup magic method with private visibiliry to prevent unserializing of
     * the *Singleton* instance.
     *
     * @return void
     */
    protected function __wakeup()
    {
    }
}