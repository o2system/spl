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

namespace O2System\Spl\Datastructures\Traits;

// ------------------------------------------------------------------------

use O2System\Spl\Datastructures\SplArrayObject;

/**
 * Trait ArrayFunctionsTrait
 *
 * Add re-usable SplArray Classes manipulations.
 *
 * @package O2System\Spl\Traits
 */
trait ArrayFunctionsTrait
{
    /**
     * ArrayFunctionsTrait::getCombine
     *
     * Creates an SplArrayObject by giving keys of the array copy.
     *
     * @see http://php.net/manual/en/function.array-combine.php
     *
     * @param array $keys Array of keys to be used. Illegal values for key will be converted to string.
     *
     * @return SplArrayObject
     */
    public function getCombine(array $keys)
    {
        $arrayCombine = array_combine($keys, $this->getArrayCopy());

        return new SplArrayObject($arrayCombine);
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayFunctionsTrait::getKeys
     *
     * Return all the keys or a subset of the array copy.
     *
     * @see http://php.net/manual/en/function.array-keys.php
     *
     * @param mixed $searchValue If specified, then only keys containing these values are returned.
     * @param bool  $strict      Determines if strict comparison (===) should be used during the search.
     *
     * @return array Returns an array of all the keys of the array copy.
     */
    public function getKeys($searchValue = null, $strict = false)
    {
        if (isset($searchValue)) {
            return array_keys($this->getArrayCopy(), $searchValue, $strict);
        }

        return array_keys($this->getArrayCopy());
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayFunctionsTrait::getValues
     *
     * Return all the values of the array copy
     *
     * @see http://php.net/manual/en/function.array-values.php
     *
     * @return array Returns an indexed array of values.
     */
    public function getValues()
    {
        return array_values($this->getArrayCopy());
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayFunctionsTrait::getSlice
     *
     * Return sliced array of storage array.
     *
     * @see http://php.net/manual/en/function.array-slice.php
     *
     * @param int  $offset       If offset is non-negative, the sequence will start at that offset in the array. If
     *                           offset is negative, the sequence will start that far from the end of the array.
     *
     * @param int  $length       If length is given and is positive, then the sequence will have up to that many
     *                           elements in it. If the array is shorter than the length, then only the available array
     *                           elements will be present. If length is given and is negative then the sequence will
     *                           stop that many elements from the end of the array. If it is omitted, then the sequence
     *                           will have everything from offset up until the end of the array.
     *
     * @param bool $preserveKeys Note that array_slice() will reorder and reset the numeric array indices by default.
     *                           You can change this behaviour by setting preserve_keys to TRUE.
     *
     * @return array Returns the slice. If the offset is larger than the size of the array then returns an empty array.
     */
    public function getSlice($offset = 0, $length = null, $preserveKeys = false)
    {
        return array_slice($this->getArrayCopy(), $offset, $length, $preserveKeys);
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayFunctionsTrait::getSlices
     *
     * Extract the slices of the array copy.
     *
     * @see http://php.net/manual/en/function.array-slice.php
     *
     * @param array $lengths      Array of lengths
     *
     * @param bool  $preserveKeys Note that array_slice() will reorder and reset the numeric array indices by default.
     *                            You can change this behaviour by setting preserve_keys to TRUE.
     *
     * @return array Returns the slices. If the offset is larger than the size of the array then returns an empty array.
     */
    public function getSlices(array $lengths, $preserveKeys = false)
    {
        $arraySlices = [];

        foreach ($lengths as $key => $length) {
            $arraySlices[ $key ] = array_slice($this->getArrayCopy(), 0, $length, $preserveKeys);
        }

        return $arraySlices;
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayFunctionsTrait::getChunk
     *
     * Return chunk array of the array copy.
     *
     * @see http://php.net/manual/en/function.array-chunk.php
     *
     * @param int  $size         The size of each chunk
     * @param bool $preserveKeys When set to TRUE keys will be preserved. Default is FALSE which will reindex the chunk
     *                           numerically
     *
     * @return array Returns a multidimensional numerically indexed array, starting with zero, with each dimension
     *               containing size elements.
     */
    public function getChunk($size, $preserveKeys = false)
    {
        return array_chunk($this->getArrayCopy(), $size, $preserveKeys);
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayFunctionsTrait::getChunks
     *
     * Return chunks array of the array copy.
     *
     * @see http://php.net/manual/en/function.array-chunk.php
     *
     * @param array $sizes        Array list of sizes of each chunk
     * @param bool  $preserveKeys When set to TRUE keys will be preserved. Default is FALSE which will reindex the
     *                            chunk numerically
     *
     * @return array Returns a multidimensional numerically indexed array, starting with zero, with each dimension
     *               containing size elements.
     */
    public function getChunks(array $sizes, $preserveKeys = false)
    {
        $arrayChunks = [];

        $offset = 0;
        foreach ($sizes as $key => $limit) {
            $arrayChunks[ $key ] = array_slice($this->getArrayCopy(), $offset, $limit, $preserveKeys);
            $offset = $limit;
        }

        return $arrayChunks;
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayFunctionsTrait::getShuffle
     *
     * Shuffle the array copy.
     *
     * @see http://php.net/manual/en/function.shuffle.php
     *
     * @return array Return shuffle array of the array copy.
     */
    public function getShuffle()
    {
        $arrayCopy = $this->getArrayCopy();
        shuffle($arrayCopy);

        return $arrayCopy;
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayFunctionsTrait::getReverse
     *
     * Return the array copy with elements in reverse order.
     *
     * @param bool $preserveKey If set to TRUE numeric keys are preserved. Non-numeric keys are not affected by this
     *                          setting and will always be preserved.
     *
     * @return array Returns the reversed array.
     */
    public function getReverse($preserveKey = false)
    {
        return array_reverse($this->getArrayCopy(), $preserveKey);
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayFunctionsTrait::getColumn
     *
     * Return the values from a single column of the array copy.
     *
     * @see http://php.net/manual/en/function.array-column.php
     *
     * @param mixed $columnKey The column of values to return. This value may be an integer key of the column you wish
     *                         to retrieve, or it may be a string key name for an associative array or property name.
     *                         It may also be NULL to return complete arrays or objects (this is useful together with
     *                         index_key to reindex the array).
     * @param mixed $indexKey  The column to use as the index/keys for the returned array. This value may be the
     *                         integer key of the column, or it may be the string key name.
     *
     * @return array Returns an array of values representing a single column from the input array.
     */
    public function getColumn($columnKey, $indexKey = null)
    {
        return array_column($this->getArrayCopy(), $columnKey, $indexKey);
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayFunctionsTrait::getFlip
     *
     * Exchanges all keys with their associated values of the array copy.
     *
     * @see http://php.net/manual/en/function.array-flip.php
     *
     * @return array Returns the flipped array on success and NULL on failure.
     */
    public function getFlip()
    {
        return array_flip($this->getArrayCopy());
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayFunctionsTrait::filter
     *
     * Filters elements of the array copy using a callback function.
     *
     * @see http://php.net/manual/en/function.array-filter.php
     *
     * @param callable $callback The callback function to use, if no callback is supplied, all entries of array equal
     *                           to FALSE (see converting to boolean) will be removed.
     * @param int      $flag     Flag determining what arguments are sent to callback.
     *
     * @return array Returns the filtered array.
     */
    public function filter($callback, $flag = 0)
    {
        return array_filter($this->getArrayCopy(), $callback, $flag);
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayFunctionsTrait::getSum
     *
     * Calculate the sum of values of the array copy.
     *
     * @see http://php.net/manual/en/function.array-sum.php
     *
     * @return int|float Returns the sum of values as an integer or float.
     */
    public function getSum()
    {
        return array_sum($this->getArrayCopy());
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayFunctionsTrait::getCountValues
     *
     * Counts all the values of the array copy.
     *
     * @see http://php.net/manual/en/function.array-count-values.php
     *
     * @return array Returns an associative array of values from array as keys and their count as value.
     */
    public function getCountValues()
    {
        return array_count_values($this->getArrayCopy());
    }
}