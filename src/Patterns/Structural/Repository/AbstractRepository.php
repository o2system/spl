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

namespace O2System\Spl\Patterns\Structural\Repository;

use O2System\Spl\Iterators\ArrayIterator;

/**
 * Class AbstractRepository
 * @package O2System\Spl\Patterns\Structural\Repository
 */
abstract class AbstractRepository implements
    StorageInterface,
    \ArrayAccess,
    \Countable,
    \IteratorAggregate,
    \Serializable,
    \JsonSerializable
{
    /**
     * AbstractRepository::$storage
     *
     * The array of data storage.
     *
     * @var array
     */
    protected $storage = [];

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::offsetSet
     *
     * Implementation of array access interface method setter as an alias of store method.
     *
     * @see  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param string $offset The data offset key.
     * @param mixed  $data   The data to be stored.
     *
     * @return void
     */
    final public function offsetSet($offset, $data)
    {
        $this->store($offset, $data);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::store
     *
     * Store the data into the storage.
     * An alias of AbstractRepository::__set method.
     *
     * @param string $offset The data offset key.
     * @param mixed  $data   The data to be stored.
     *
     * @return void
     */
    public function store($offset, $data)
    {
        $this->storage[ $offset ] = $data;
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::__get
     *
     * Implementation of magic method getter and as an alias of get method.
     *
     * @see http://php.net/manual/en/language.oop5.overloading.php#object.get
     *
     * @param string $offset The object offset key.
     *
     * @return mixed Varies depends the data contents, return NULL when there offset is not found.
     */
    final public function __get($offset)
    {
        return $this->get($offset);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::__set
     *
     * Implementation of magic method setter as an alias of store method.
     *
     * @see  http://php.net/manual/en/language.oop5.overloading.php#object.set
     *
     * @param string $offset The data offset key.
     * @param mixed  $data   The data to be stored.
     *
     * @return void
     */
    final public function __set($offset, $data)
    {
        $this->store($offset, $data);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::get
     *
     * Retrieve the contained object which specified offset key.
     * An alias of AbstractRepository::__get method.
     *
     * @param string $offset The object offset key.
     *
     * @return mixed Varies depends the data contents, return NULL when there offset is not found.
     */
    public function get($offset)
    {
        if ($this->__isset($offset)) {
            return $this->storage[ $offset ];
        }
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::__isset
     *
     * Implementation of magic method to check inaccessible properties
     * and as an alias of exists method.
     *
     * @see http://php.net/manual/en/language.oop5.overloading.php#object.isset
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
     * AbstractRepository::exists
     *
     * Checks if the data exists on the storage.
     *
     * @param string $offset The object offset key.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function exists($offset)
    {
        return (bool)isset($this->storage[ $offset ]);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::offsetGet
     *
     * Implementation of array access interface method getter
     * and as an alias of get method.
     *
     * @see  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param string $offset The object offset key.
     *
     * @return mixed Varies depends the data contents, return NULL when there offset is not found.
     */
    final public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::offsetExists
     *
     * Implementation of array access interface to check inaccessible properties
     * and as an alias of exists method.
     *
     * @see http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param string $offset The object offset key.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    final public function offsetExists($offset)
    {
        return $this->exists($offset);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::__unset
     *
     * Implementation of magic method unset to remove inaccessible properties
     * and as an alias of remove method.
     *
     * @see http://php.net/manual/en/language.oop5.overloading.php#object.unset
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
     * AbstractRepository::remove
     *
     * Removes a data from the storage.
     * An alias of AbstractRepository::__unset method.
     *
     * @param string $offset The object offset key.
     *
     * @return void
     */
    public function remove($offset)
    {
        if ($this->__isset($offset)) {
            unset($this->storage[ $offset ]);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::offsetUnset
     *
     * Implementation of array access interface unset method to remove inaccessible properties
     * and as an alias of remove method.
     *
     * @see  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param string $offset The object offset key.
     *
     * @return void
     */
    final public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::destroy
     *
     * Removes all data from the storage.
     *
     * @return array Array of old storage items.
     */
    public function destroy()
    {
        $storage = $this->storage;

        $this->storage = [];

        return $storage;
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::merge
     *
     * Merge new array of data into the data storage.
     *
     * @param array $data New array of data.
     *
     * @return array The old array of data storage.
     */
    public function merge(array $data)
    {
        $oldStorage = $this->storage;
        $this->storage = array_merge($this->storage, $data);

        return $oldStorage;
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::exchange
     *
     * Exchange the array of data storage into the new array of data.
     *
     * @param array $data New array of data.
     *
     * @return array The old array of data storage.
     */
    public function exchange(array $data)
    {
        $oldStorage = $this->storage;
        $this->storage = $data;

        return $oldStorage;
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::search
     *
     * Search data based on array offset key.
     *
     * @param string $offset The data offset key.
     * @param mixed  $return The fail over of data returns when the data is not found.
     *
     * @return mixed The returns is varies depends on the content of the data or the return variable.
     */
    public function search($offset, $return = false)
    {
        if (array_key_exists($offset, $this->storage)) {
            return $this->storage[ $offset ];
        } elseif (false !== ($offsetKey = array_search($offset, $this->storage))) {
            return $this->storage[ $offsetKey ];
        }

        return $return;
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::count
     *
     * Application of Countable::count method to count the numbers of contained objects.
     *
     * @see  http://php.net/manual/en/countable.count.php
     * @return int The numbers of data on the storage.
     */
    final public function count()
    {
        return (int)count($this->storage);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractDataStorage::serialize
     *
     * Application of Serializable::serialize method to serialize the data storage.
     *
     * @see  http://php.net/manual/en/serializable.serialize.php
     *
     * @return string The string representation of the serialized data storage.
     */
    final public function createSerialize($callback)
    {
        return call_user_func($callback, [$this->storage]);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractDataStorage::serialize
     *
     * Application of Serializable::serialize method to serialize the data storage.
     *
     * @see  http://php.net/manual/en/serializable.serialize.php
     *
     * @return string The string representation of the serialized data storage.
     */
    final public function serialize()
    {
        return serialize($this->storage);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractDataStorage::unserialize
     *
     * Application of Serializable::unserialize method to unserialize and construct the data storage.
     *
     * @see  http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized The string representation of the serialized data storage.
     *
     * @return void
     */
    final public function unserialize($serialized)
    {
        $this->storage = unserialize($serialized);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractDataStorage::jsonSerialize
     *
     * Specify data which should be serialized to JSON
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *        which is a value of any type other than a resource.
     * @since 5.4.0
     */
    final public function jsonSerialize()
    {
        return $this->storage;
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractRepository::getArrayCopy
     *
     * Gets a copy of the data storage.
     *
     * @return array Returns a copy of the data storage.
     */
    public function getArrayCopy()
    {
        return $this->storage;
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