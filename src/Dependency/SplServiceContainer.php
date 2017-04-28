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

namespace O2System\Spl\Dependency;

// ------------------------------------------------------------------------

/**
 * Class SplServiceContainer
 *
 * @package O2System\Spl\Dependency
 */
class SplServiceContainer implements \Countable
{
    /**
     * Inversion Control Closure Container
     *
     * @var array
     */
    private $registry = [];

    // ------------------------------------------------------------------------

    /**
     * SplServiceContainer::attach
     *
     * Adds an closure object in the registry.
     *
     * @param string   $offset
     * @param \Closure $closure
     */
    public function attach( $offset, \Closure $closure )
    {
        $this->registry[ $offset ] = $closure;
    }

    // ------------------------------------------------------------------------

    /**
     * SplServiceContainer::detach
     *
     * Removes a specific closure object
     *
     * @param string $offset
     */
    public function detach( $offset )
    {
        if ( isset( $this->registry[ $offset ] ) ) {
            unset( $this->registry[ $offset ] );
        }
    }

    // ------------------------------------------------------------------------

    /**
     * SplServiceContainer::contains
     *
     * Checks if the registry contains a specific closure object.
     *
     * @param string $offset
     *
     * @return bool
     */
    public function contains( $offset )
    {
        return (bool)isset( $this->registry[ $offset ] );
    }

    // ------------------------------------------------------------------------

    /**
     * SplServiceContainer::resolve
     *
     * Returns the closure object result.
     *
     * @param string $offset
     * @param array  $arguments
     *
     * @return mixed Returns FALSE when calling the closure is failed.
     */
    public function resolve( $offset, array $arguments = [] )
    {
        return isset( $this->registry[ $offset ] ) ? call_user_func_array(
            $this->registry[ $offset ],
            $arguments
        ) : false;
    }

    // ------------------------------------------------------------------------

    /**
     * SplServiceContainer::count
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
        return count( $this->registry );
    }
}