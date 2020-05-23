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

namespace O2System\Spl\Containers;

// ------------------------------------------------------------------------

use Psr\Container\ContainerInterface;

/**
 * Class SplClosureContainer
 *
 * @package O2System\Spl\Dependency
 */
class SplClosureContainer implements \Countable, ContainerInterface
{
    /**
     * Inversion Control Closure Container
     *
     * @var array
     */
    protected $closures = [];

    // ------------------------------------------------------------------------

    /**
     * SplClosureContainer::attach
     *
     * Adds an closure object in the registry.
     *
     * @param string   $offset
     * @param \Closure $closure
     */
    public function attach($offset, \Closure $closure)
    {
        $this->closures[ $offset ] = $closure;
    }

    // ------------------------------------------------------------------------

    /**
     * SplClosureContainer::__isset
     *
     * A convenient way to checks if the registry has a specific closure object,
     * by doing isset( $ioc->offset )
     *
     * @param string $offset
     *
     * @return bool
     */
    public function __isset($offset)
    {
        return $this->has($offset);
    }

    // ------------------------------------------------------------------------

    /**
     * SplClosureContainer::has
     *
     * Checks if the registry contains a specific closure object.
     *
     * @param string $offset
     *
     * @return bool
     */
    public function has($offset)
    {
        return (bool)isset($this->closures[ $offset ]);
    }

    // ------------------------------------------------------------------------

    /**
     * SplClosureContainer::__unset
     *
     * A convenient way to removes a specific closure object
     * by doing unset( $ioc->offset )
     *
     * @param string $offset
     */
    public function __unset($offset)
    {
        $this->detach($offset);
    }

    // ------------------------------------------------------------------------

    /**
     * SplClosureContainer::detach
     *
     * Removes a specific closure object
     *
     * @param string $offset
     */
    public function detach($offset)
    {
        if (isset($this->closures[ $offset ])) {
            unset($this->closures[ $offset ]);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * SplClosureContainer::__call
     *
     * A convenient way to access the closure object result
     * by doing $ioc->offset('foo', 'bar');
     *
     * @param string $offset
     * @param array  $arguments
     *
     * @return mixed Returns FALSE when calling the closure is failed.
     */
    public function __call($offset, array $arguments = [])
    {
        return $this->get($offset, $arguments);
    }

    // ------------------------------------------------------------------------

    /**
     * SplClosureContainer::get
     *
     * Returns the closure object result.
     *
     * @param string $offset
     * @param array  $arguments
     *
     * @return mixed Returns FALSE when calling the closure is failed.
     */
    public function get($offset, array $arguments = [])
    {
        return isset($this->closures[ $offset ]) ? call_user_func_array(
            $this->closures[ $offset ],
            $arguments
        ) : false;
    }

    // ------------------------------------------------------------------------

    /**
     * SplClosureContainer::count
     *
     * Count elements of an object
     *
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     *        </p>
     *        <p>
     *        The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->closures);
    }
}