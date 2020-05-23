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

namespace O2System\Spl\Iterators;

// ------------------------------------------------------------------------

use O2System\Spl\DataStructures\Traits\ArrayConversionTrait;
use O2System\Spl\DataStructures\Traits\ArrayFunctionsTrait;

/**
 * O2System Standard PHP Libraries ArrayIterator
 *
 * @package O2System\Core\SPL
 */
class ArrayIterator extends \ArrayIterator implements \JsonSerializable
{
    use ArrayConversionTrait;
    use ArrayFunctionsTrait;

    // ------------------------------------------------------------------------

    /**
     * ArrayIterator::first
     *
     * Rewind the iterator to the first offset
     *
     * @return mixed
     */
    public function first()
    {
        $this->rewind();

        return $this->current();
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayIterator::last
     *
     * Forward the iterator to the first offset
     *
     * @return mixed
     */
    public function last()
    {
        $this->seek(($this->count()) - 1);

        return $this->current();
    }

    /**
     * ArrayIterator::push
     *
     * Push a value for an offset
     *
     * @param mixed $value The new value to store at the index.
     */
    public function push($value)
    {
        $this->offsetSet($this->count(), $value);
        $this->seek($this->count() - 1);
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayIterator::unshift
     *
     * Prepend one or more value to the beginning of the storage
     *
     * @param mixed $value The new value to store at the index.
     */
    public function unshift($value)
    {
        $storage = $this->getArrayCopy();
        array_unshift($storage, $value);

        parent::__construct($storage);
    }

    // ------------------------------------------------------------------------

    public function shift()
    {
        $storage = $this->getArrayCopy();
        array_shift($storage);

        parent::__construct($storage);
    }

    public function pop()
    {
        $storage = $this->getArrayCopy();
        array_pop($storage);

        parent::__construct($storage);
    }

    /**
     * ArrayIterator::has
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
        return (bool)in_array($needle, $this->getArrayCopy(), $strict);
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayIterator::search
     *
     * Searches the storage for a given value and returns the first corresponding key if successful.
     *
     * @param mixed $needle The searched value.
     * @param bool  $seek   Perform the iterator seek method
     *
     * @return mixed Returns the key for needle if it is found in the array, FALSE otherwise.
     */
    public function search($needle, $seek = false)
    {
        if (false !== ($position = array_search($needle, $this->getArrayCopy()))) {
            if ($seek === true) {
                $this->seek($position);
            }

            return $position;
        }

        return false;
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayIterator::unique
     *
     * Removes duplicate values from the storage
     *
     * @see http://php.net/manual/en/function.array-unique.php
     *
     * @param int  $sortFlags     The optional second parameter sort_flags may be used to modify the sorting behavior
     * @param bool $exchangeArray Exchange the array into the filtered array.
     *
     * @return array Returns the filtered array.
     */
    public function unique($sortFlags = SORT_STRING, $exchangeArray = false)
    {
        $unique = array_unique($this->getArrayCopy(), $sortFlags);

        if ($exchangeArray) {
            $this->exchangeArray($unique);
        }

        return $unique;
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayIterator::exchangeArray
     *
     * Exchange the array for another one.
     *
     * @param array $values The new array or object to exchange with the current array.
     *
     *
     * @return array of the old storage.
     * @since 5.1.0
     */
    public function exchangeArray(array $values)
    {
        $oldStorage = $this->getArrayCopy();
        parent::__construct($values);

        return $oldStorage;
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayIterator::merge
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
     * ArrayIterator::remove
     *
     * Remove a given needle from the storage.
     *
     * @param mixed $needle The searched value.
     *
     * @return void
     */
    public function remove($needle)
    {
        if (false !== ($position = array_search($needle, $this->getArrayCopy()))) {
            $firstStorage = array_splice($this->getArrayCopy(), 0, $position);
            $endStorage = array_splice($this->getArrayCopy(), $position + 1);

            parent::__construct(array_merge($firstStorage, $endStorage));
        }
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayIterator::jsonSerialize
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
        return $this->getArrayCopy();
    }
}