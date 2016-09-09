<?php
/**
 * O2System
 *
 * An open source application development framework for PHP 5.4.0 or newer
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014, O2System Framework Developer Team
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package        O2System\Core
 * @author         O2System Framework Developer Team
 * @copyright      Copyright (c) 2005 - 2014, O2System PHP Framework
 * @license        http://www.o2system.io/license.html
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link           http://www.o2system.io
 * @since          Version 2.0
 * @filesource
 */
// ------------------------------------------------------------------------

namespace O2System\Spl\Traits;

// ------------------------------------------------------------------------

use O2System\Core\SPL\ArrayObject;

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
	 * Get Combine
	 *
	 * Creates an ArrayObject by giving keys of the storage array.
	 *
	 * @param array $keys
	 *
	 * @return \O2System\Core\SPL\ArrayObject
	 */
	public function getCombine( array $keys )
	{
		$arrayCombine = array_combine( $keys, $this->getArrayCopy() );

		return new ArrayObject( $arrayCombine );
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Keys
	 *
	 * Return all the keys or a subset of the storage array
	 *
	 * @param mixed $searchValue If specified, then only keys containing these values are returned.
	 * @param bool  $strict      Determines if strict comparison (===) should be used during the search.
	 *
	 * @return array
	 */
	public function getKeys( $searchValue = NULL, $strict = FALSE )
	{
		if ( isset( $searchValue ) )
		{
			return array_keys( $this->getArrayCopy(), $searchValue, $strict );
		}

		return array_keys( $this->getArrayCopy() );
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Values
	 *
	 * Return all the values of the storage array
	 *
	 * @return array
	 */
	public function getValues()
	{
		return array_values( $this->getArrayCopy() );
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Slice
	 *
	 * Return sliced array of storage array.
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
	 * @return array
	 */
	public function getSlice( $offset = 0, $length = NULL, $preserveKeys = FALSE )
	{
		return array_slice( $this->getArrayCopy(), $offset, $length, $preserveKeys );
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Slices
	 *
	 * Return slices array of storage array.
	 *
	 * @param array $lengths      Array of lengths
	 *
	 * @param bool  $preserveKeys Note that array_slice() will reorder and reset the numeric array indices by default.
	 *                            You can change this behaviour by setting preserve_keys to TRUE.
	 *
	 * @return array
	 */
	public function getSlices( array $lengths, $preserveKeys = FALSE )
	{
		$arraySlices = [ ];

		foreach ( $lengths as $key => $length )
		{
			$arraySlices[ $key ] = array_slice( $this->getArrayCopy(), 0, $length, $preserveKeys );
		}

		return $arraySlices;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Chunk
	 *
	 * Return chunk array of the storage array.
	 *
	 * @param int  $size         The size of each chunk
	 * @param bool $preserveKeys When set to TRUE keys will be preserved. Default is FALSE which will reindex the chunk
	 *                           numerically
	 *
	 * @return array
	 */
	public function getChunk( $size, $preserveKeys = FALSE )
	{
		return array_chunk( $this->getArrayCopy(), $size, $preserveKeys );
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Chunks
	 *
	 * Return chunk array of the storage array.
	 *
	 * @param array $sizes        Array sizes of each chunk
	 * @param bool  $preserveKeys When set to TRUE keys will be preserved. Default is FALSE which will reindex the
	 *                            chunk numerically
	 *
	 * @return array
	 */
	public function getChunks( array $sizes, $preserveKeys = FALSE )
	{
		$arrayChunks = [ ];

		$offset = 0;
		foreach ( $sizes as $key => $limit )
		{
			$arrayChunks[ $key ] = array_slice( $this->getArrayCopy(), $offset, $limit, $preserveKeys );
			$offset              = $limit;
		}

		return $arrayChunks;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Shuffle
	 *
	 * Return shuffle array of the storage array.
	 *
	 * @return array
	 */
	public function getShuffle()
	{
		$arrayCopy = $this->getArrayCopy();
		shuffle( $arrayCopy );

		return $arrayCopy;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Reverse
	 *
	 * Return the storage array with elements in reverse order
	 *
	 * @return array
	 */
	public function getReverse()
	{
		return array_reverse( $this->getArrayCopy() );
	}

	/**
	 * Get Array Column
	 *
	 * Return the values from a single column in the storage
	 *
	 * @param $column
	 *
	 * @return array
	 */
	public function getColumn( $column )
	{
		return array_column( $this->getArrayCopy(), $column );
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Array Flip
	 *
	 * Returns the flipped array
	 *
	 * @return array
	 */
	public function getFlip()
	{
		return array_flip( $this->getArrayCopy() );
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Filter
	 *
	 * Filters elements of the storage array using a callback function
	 *
	 * @param callable $callback
	 * @param int      $flag
	 *
	 * @return array
	 */
	public function filter( $callback, $flag = 0 )
	{
		return array_filter( $this->getArrayCopy(), $callback, $flag );
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Array Sum
	 *
	 * Calculate the sum of values in storage
	 *
	 * @return number
	 */
	public function getSum()
	{
		return array_sum( $this->getArrayCopy() );
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Count Values
	 *
	 * Counts all the values of storage array
	 *
	 * @return array
	 */
	public function getCountValues()
	{
		return array_count_values( $this->getArrayCopy() );
	}
}