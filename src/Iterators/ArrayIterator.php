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

namespace O2System\Spl\Iterators;

// ------------------------------------------------------------------------

use O2System\Spl\Traits\ArrayConversionTrait;
use O2System\Spl\Traits\ArrayFunctionsTrait;

/**
 * O2System Standard PHP Libraries ArrayIterator
 *
 * @package O2System\Core\SPL
 */
class ArrayIterator extends \ArrayIterator
{
	use ArrayConversionTrait;
	use ArrayFunctionsTrait;

	public function first()
	{
		$this->rewind();

		return $this->current();
	}

	public function last()
	{
		$this->seek( ( $this->count() ) - 1 );

		return $this->current();
	}

	public function push( $value )
	{
		$this->offsetSet( $this->count(), $value );
	}

	public function unshift( $value )
	{
		$storage = $this->getArrayCopy();
		array_unshift( $storage, $value );

		parent::__construct( $storage );
	}

	/**
	 * Exchange the array for another one.
	 *
	 * @param array $values <p>
	 *                      The new array or object to exchange with the current array.
	 *                      </p>
	 *
	 * @return array the old array.
	 * @since 5.1.0
	 */
	public function exchangeArray( array $values )
	{
		$oldStorage = $this->getArrayCopy();
		parent::__construct( $values );

		return $oldStorage;
	}

	/**
	 * Has
	 *
	 * Perform array_search to find needle
	 *
	 * @param $needle
	 *
	 * @return mixed
	 */
	public function has( $needle, $strict = FALSE )
	{
		return (bool) in_array( $needle, $this->getArrayCopy(), $strict );
	}

	/**
	 * Has
	 *
	 * Perform array_search to find needle
	 *
	 * @param $needle
	 *
	 * @return mixed
	 */
	public function search( $needle, $setPosition = FALSE )
	{
		if ( FALSE !== ( $position = array_search( $needle, $this->getArrayCopy() ) ) )
		{
			if ( $setPosition === TRUE )
			{
				$this->seek( $position );
			}

			return $position;
		}

		return FALSE;
	}

	/**
	 * Get Array Unique
	 *
	 * Removes duplicate values from storage
	 *
	 * @param int $sortFlags
	 *
	 * @return array
	 */
	public function unique( $sortFlags = SORT_STRING, $exchangeArray = FALSE )
	{
		$unique = array_unique( $this->getArrayCopy(), $sortFlags );

		if ( $exchangeArray )
		{
			$this->exchangeArray( $unique );
		}

		return $unique;
	}

	public function merge( $values )
	{
		$storage = $this->getArrayCopy();
		$storage = array_merge( $storage, $values );

		parent::__construct( $storage );
	}

	public function remove( $value )
	{
		if ( FALSE !== ( $position = array_search( $value, $this->getArrayCopy() ) ) )
		{
			$firstStorage = array_splice( $this->getArrayCopy(), 0, $position );
			$endStorage   = array_splice( $this->getArrayCopy(), $position + 1 );

			parent::__construct( array_merge( $firstStorage, $endStorage ) );
		}

		return FALSE;
	}
}