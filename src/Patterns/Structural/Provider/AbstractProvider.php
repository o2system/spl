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

namespace O2System\Spl\Patterns\Structural\Provider;

use O2System\Spl\Iterators\ArrayIterator;

/**
 * Class AbstractProvider
 *
 * The best practice of this pattern class is to contain many objects instance
 * which require to be validated.
 *
 * This pattern class is designed to be able to traversable using foreach.
 *
 * Note: This class is an abstract class so it can not be initiated.
 *
 * @package O2System\Spl\Patterns\Structural\Provider
 */
abstract class AbstractProvider implements
    RegistryInterface,
    \IteratorAggregate,
    \Countable
{
    /**
     * AbstractProvider::$registry
     *
     * The array of contained objects.
     * The access of this property is private so can't be manipulated from the child classes.
     *
     * @var array
     */
    protected $registry = [];

    // ------------------------------------------------------------------------

    /**
     * AbstractProvider::__get
     *
     * Application of __get magic method to retrieve the registered object which specified offset key.
     *
     * @param string $offset The object offset key.
     *
     * @return mixed Varies depends the data contents, return NULL when there offset is not found.
     */
    final public function &__get($offset)
    {
        return $this->getObject($offset);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractProvider::__set
     *
     * Application of __set magic method to registered the object into the container.
     *
     * @param string $offset The object offset key.
     * @param mixed  $object The object to be contained.
     *
     * @return void
     */
    final public function __set($offset, $object)
    {
        $this->register($object, $offset);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractProvider::getObject
     *
     * Retrieve the contained object which specified offset key.
     * An alias of AbstractProvider::__get method.
     *
     * @param string $offset The object offset key.
     *
     * @return mixed Varies depends the data contents, return NULL when there offset is not found.
     */
    public function &getObject($offset)
    {
        $get[ $offset ] = null;

        if ($this->__isset($offset)) {
            return $this->registry[ $offset ];
        }

        return $get[ $offset ];
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractProvider::__isset
     *
     * Implements magic method isset to checks inaccessible properties.
     *
     * @param string $offset The object offset key.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    final public function __isset($offset)
    {
        return $this->exists($offset);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractProvider::has
     *
     * Checks if the provider has registry of an object with specified offset key.
     * An alias of AbstractProvider::__isset method.
     *
     * @param string $offset The object offset key.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function exists($offset)
    {
        return (bool)isset($this->registry[ $offset ]);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractProvider::register
     *
     * Register the object into the class container.
     * An alias of AbstractProvider::__set method.
     *
     * @param object $object The object to be contained.
     * @param string $offset The object container array offset key.
     *
     * @return void
     */
    public function register($object, $offset = null)
    {
        if (is_object($object)) {
            if ($this instanceof ValidationInterface) {
                if ($this->validate($object) === false) {
                    return;
                }
            }

            if (is_null($offset)) {
                $offset = get_class($object);
                $offset = pathinfo($offset, PATHINFO_FILENAME);
            }

            if ( ! $this->__isset($offset)) {
                $this->registry[ $offset ] = $object;
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractProvider::__unset
     *
     * Removes an objects from the container.
     *
     * @param string $offset The object offset key.
     *
     * @return void
     */
    final public function __unset($offset)
    {
        $this->remove($offset);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractProvider::remove
     *
     * Unregister an objects from the registry.
     * An alias of AbstractProvider::__unset method.
     *
     * @param string $offset The object offset key.
     *
     * @return void
     */
    public function remove($offset)
    {
        if ($this->__isset($offset)) {
            if (method_exists($this->registry[ $offset ], '__destruct')) {
                $this->registry[ $offset ]->__destruct();
            }

            unset($this->registry[ $offset ]);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractProvider::destroy
     *
     * Removes all objects from the registry and perform each object destruction.
     *
     * @return array Array of old registry
     */
    final public function destroy()
    {
        foreach ($this->registry as $offset => $object) {
            if (method_exists($object, '__destruct')) {
                $object->__destruct();
            }
            unset($this->registry[ $offset ]);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractProvider::getObjectHash
     *
     * Gets a unique identifier for the registered object.
     *
     * @param $offset
     *
     * @return bool|string Returns FALSE on failure, or unique string identifier of the registered object on success.
     */
    final public function getObjectHash($offset)
    {
        if ($this->__isset($offset)) {
            return spl_object_hash($this->registry[ $offset ]);
        }

        return false;
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractProvider::getObjectId
     *
     * Gets the integer object handle for the registered object.
     *
     * @param $offset
     *
     * @return bool|int Returns FALSE on failure, or the integer object handle for given object on success.
     */
    final public function getObjectId($offset)
    {
        if ($this->__isset($offset)) {
            return spl_object_id($this->registry[ $offset ]);
        }

        return false;
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractProvider::count
     *
     * Application of Countable::count method to count the numbers of registered objects.
     *
     * @see http://php.net/manual/en/countable.count.php
     *
     * @return int The numbers of registered objects.
     */
    final public function count()
    {
        return (int)count($this->registry);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractProvider::getIterator
     *
     * Application of IteratorAggregate::getIterator method to retrieve an external iterator.
     *
     * @see  http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return \ArrayIterator
     */
    final public function getIterator()
    {
        return new ArrayIterator($this->registry);
    }
}