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

namespace O2System\Spl\Datastructures;

// ------------------------------------------------------------------------

use O2System\Spl\Iterators\ArrayIterator;
use Traversable;

class SplArrayStorage implements
    \Countable,
    \IteratorAggregate,
    \Serializable,
    \JsonSerializable,
    \ArrayAccess
{
    use Traits\ArrayConversionTrait;
    use Traits\ArrayFunctionsTrait;

    /**
     * SplArrayStorage
     *
     * @var array
     */
    protected $storage = [];

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::__isset
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function __isset($offset)
    {
        return isset($this->storage[ $offset ]);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::__unset
     *
     * Unset a given offset.
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     */
    public function __unset($offset)
    {
        unset($this->storage[ $offset ]);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::__get
     *
     * Offset to retrieve
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return mixed Can return all value types.
     */
    public function &__get($offset)
    {
        return $this->offsetGet($offset);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::__set
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     */
    public function __set($offset, $value)
    {
        $this->offsetSet($offset, $value);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::offsetGet
     *
     * Offset to retrieve
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->storage[ $offset ];
        } else {
            $this->storage[ $offset ] = [];

            return $this->storage[ $offset ];
        }
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::offsetExists
     *
     * Whether a offset exists
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return (bool)isset($this->storage[ $offset ]);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::offsetSet
     *
     * Offset to set
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->storage[ $offset ] = $value;
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::offsetUnset
     *
     * Offset to unset
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        if (isset($this->storage[ $offset ])) {
            unset($this->storage[ $offset ]);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::offsetGetFilter
     *
     * Get filtered array storage value
     *
     * @param      $offset
     * @param null $filter
     *
     * @return mixed|null
     */
    public function offsetGetFilter($offset, $filter = null)
    {
        if ($this->offsetExists($offset)) {
            $storage = $this->offsetGet($offset);

            if (is_array($storage) AND is_array($filter)) {
                return filter_var_array($offset, $filter);
            } elseif (is_array($storage) AND isset($filter)) {
                foreach ($storage as $key => $value) {
                    $storage[ $key ] = filter_var($value, $filter);
                }
            } elseif (isset($filter)) {
                return filter_var($storage, $filter);
            }

            return $storage;
        }

        return false;
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::append
     *
     * append array of values into the storage
     *
     * @param array $values Variable list of arrays to merge.
     *
     * @return array The array merged copy of the resulting array
     */
    public function append(array $values)
    {
        $this->storage = array_merge($this->storage, $values);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::merge
     *
     * Merge array of values into the storage
     *
     * @param array $values Variable list of arrays to merge.
     *
     * @return array The array merged copy of the resulting array
     */
    public function merge(array $values)
    {
        $storage = $this->getArrayCopy();
        $storage = array_merge($storage, $values);

        $this->exchangeArray($storage);

        return $storage;
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::getArrayCopy
     *
     * Creates a copy of the storage.
     *
     * @return array A copy of the storage.
     */
    public function getArrayCopy()
    {
        return $this->storage;
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::exchangeArray
     *
     * Exchange the array for another one.
     *
     * @link  http://php.net/manual/en/arrayobject.exchangearray.php
     *
     * @param array $values <p>
     *                      The new array or object to exchange with the current array.
     *                      </p>
     *
     * @return array the old array.
     * @since 5.1.0
     */
    public function exchangeArray(array $values)
    {
        $oldStorage = $this->storage;
        $this->storage = $values;

        return $oldStorage;
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::asort
     *
     * Sort the entries by value
     *
     * @link  http://php.net/manual/en/arrayobject.asort.php
     *
     * @param int $sortFlags
     *
     * @return void
     * @since 5.2.0
     */
    public function asort($sortFlags = SORT_REGULAR)
    {
        asort($this->storage, $sortFlags);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::ksort
     *
     * Sort the entries by key
     *
     * @link  http://php.net/manual/en/arrayobject.ksort.php
     *
     * @param int $sortFlags
     *
     * @return void
     * @since 5.2.0
     */
    public function ksort($sortFlags = SORT_REGULAR)
    {
        ksort($this->storage, $sortFlags);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::uasort
     *
     * Sort the entries with a user-defined comparison function and maintain key association
     *
     * @link  http://php.net/manual/en/arrayobject.uasort.php
     *
     * @param callback $comparisonFunction <p>
     *                                     Function <i>comparisonFunction</i> should accept two
     *                                     parameters which will be filled by pairs of entries.
     *                                     The comparison function must return an integer less than, equal
     *                                     to, or greater than zero if the first argument is considered to
     *                                     be respectively less than, equal to, or greater than the
     *                                     second.
     *                                     </p>
     *
     * @return void
     * @since 5.2.0
     */
    public function uasort($comparisonFunction)
    {
        uasort($this->storage, $comparisonFunction);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::uksort
     *
     * Sort the entries by keys using a user-defined comparison function
     *
     * @link  http://php.net/manual/en/arrayobject.uksort.php
     *
     * @param callback $comparisonFunction <p>
     *                                     The callback comparison function.
     *                                     </p>
     *                                     <p>
     *                                     Function <i>comparisonFunction</i> should accept two
     *                                     parameters which will be filled by pairs of entry keys.
     *                                     The comparison function must return an integer less than, equal
     *                                     to, or greater than zero if the first argument is considered to
     *                                     be respectively less than, equal to, or greater than the
     *                                     second.
     *                                     </p>
     *
     * @return void
     * @since 5.2.0
     */
    public function uksort($comparisonFunction)
    {
        uksort($this->storage, $comparisonFunction);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::natsort
     *
     * Sort entries using a "natural order" algorithm
     *
     * @link  http://php.net/manual/en/arrayobject.natsort.php
     * @return void
     * @since 5.2.0
     */
    public function natsort()
    {
        natsort($this->storage);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::natcasesort
     *
     * Sort an array using a case insensitive "natural order" algorithm
     *
     * @link  http://php.net/manual/en/arrayobject.natcasesort.php
     * @return void
     * @since 5.2.0
     */
    public function natcasesort()
    {
        natcasesort($this->storage);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::isEmpty
     *
     * Checks if the array storage is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return (bool)empty($this->storage);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::has
     *
     * Checks if a value exists in the storage.
     *
     * @param mixed $needle The searched value.
     * @param bool  $strict If the third parameter strict is set to TRUE then the in_array() function will also check
     *                      the types of the needle in the haystack.
     *
     * @return bool
     */
    public function has($needle, $strict = false)
    {
        return in_array($needle, $this->getArrayCopy(), $strict);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::serialize
     *
     * String representation of object
     *
     * @link  http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize($this->storage);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::unserialize
     *
     * Constructs the storage
     *
     * @link  http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     *
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        $this->storage = unserialize($serialized);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::count
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
        return count($this->storage);
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::jsonSerialize
     *
     * Specify data which should be serialized to JSON
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *        which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->storage;
    }

    // ------------------------------------------------------------------------

    /**
     * SplArrayStorage::getIterator
     *
     * Retrieve an external iterator
     *
     * @link  http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     *        <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new ArrayIterator($this->storage);
    }
}