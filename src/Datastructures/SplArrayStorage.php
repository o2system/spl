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
 * @package        O2System\Spl
 * @author         O2System Framework Developer Team
 * @copyright      Copyright (c) 2005 - 2014, O2System PHP Framework
 * @license        http://www.o2system.io/license.html
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link           http://www.o2system.io
 * @since          Version 2.0
 * @filesource
 */
// ------------------------------------------------------------------------

namespace O2System\Spl\Datastructures;

// ------------------------------------------------------------------------

use Traversable;

class SplArrayStorage implements \Countable, \IteratorAggregate, \Serializable, \JsonSerializable, \ArrayAccess
{
	/**
	 * SplArrayStorage
	 *
	 * @var array
	 */
	protected $storage = [ ];

	// ------------------------------------------------------------------------

	/**
	 * Magic method __isset
	 *
	 * @param $offset
	 *
	 * @return bool
	 */
	public function __isset( $offset )
	{
		return isset( $this->storage[ $offset ] );
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic method __unset
	 *
	 * @param $offset
	 */
	public function __unset( $offset )
	{
		unset( $this->storage[ $offset ] );
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic method __set
	 *
	 * @param string $offset
	 * @param mixed  $value
	 */
	public function __set( $offset, $value )
	{
		$this->offsetSet( $offset, $value );
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic method __get
	 *
	 * @param $offset
	 *
	 * @return mixed|null
	 */
	public function &__get( $offset )
	{
		return $this->offsetGet( $offset );
	}

	// ------------------------------------------------------------------------

	/**
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
	public function offsetExists( $offset )
	{
		return (bool) isset( $this->storage[ $offset ] );
	}

	// ------------------------------------------------------------------------

	/**
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
	public function offsetGet( $offset )
	{
		if ( $this->offsetExists( $offset ) )
		{
			return $this->storage[ $offset ];
		}
		else
		{
			$this->storage[ $offset ] = [ ];

			return $this->storage[ $offset ];
		}
	}

	// ------------------------------------------------------------------------

	/**
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
	public function offsetSet( $offset, $value )
	{
		$this->storage[ $offset ] = $value;
	}

	// ------------------------------------------------------------------------

	/**
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
	public function offsetUnset( $offset )
	{
		if ( isset( $this->storage[ $offset ] ) )
		{
			unset( $this->storage[ $offset ] );
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Offset Filter
	 *
	 * Get filtered array storage value
	 *
	 * @param      $offset
	 * @param null $filter
	 *
	 * @return mixed|null
	 */
	public function offsetFilter( $offset, $filter = NULL )
	{
		if ( $this->offsetExists( $offset ) )
		{
			$storage = $this->offsetGet( $offset );

			if ( is_array( $storage ) AND is_array( $filter ) )
			{
				return filter_var_array( $offset, $filter );
			}
			elseif ( is_array( $storage ) AND isset( $filter ) )
			{
				foreach ( $storage as $key => $value )
				{
					$storage[ $key ] = filter_var( $value, $filter );
				}
			}
			elseif ( isset( $filter ) )
			{
				return filter_var( $storage, $filter );
			}

			return $storage;
		}

		return NULL;
	}

	// ------------------------------------------------------------------------

	/**
	 * Append
	 *
	 * Appends the value
	 *
	 * @param array $values <p>
	 *                      The value being appended.
	 *                      </p>
	 *
	 * @return void
	 * @since 5.0.0
	 */
	public function append( array $values )
	{
		$this->storage = array_merge( $this->storage, $values );
	}

	// ------------------------------------------------------------------------

	/**
	 * Merge
	 *
	 * Merge one or more arrays
	 */
	public function merge()
	{
		$lists = func_get_args();

		foreach ( $lists as $array )
		{
			$this->append( $array );
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Sort the entries by value
	 *
	 * @link  http://php.net/manual/en/arrayobject.asort.php
	 *
	 * @param int $sortFlags
	 *
	 * @return void
	 * @since 5.2.0
	 */
	public function asort( $sortFlags = SORT_REGULAR )
	{
		asort( $this->storage, $sortFlags );
	}

	// ------------------------------------------------------------------------

	/**
	 * Sort the entries by key
	 *
	 * @link  http://php.net/manual/en/arrayobject.ksort.php
	 *
	 * @param int $sortFlags
	 *
	 * @return void
	 * @since 5.2.0
	 */
	public function ksort( $sortFlags = SORT_REGULAR )
	{
		ksort( $this->storage, $sortFlags );
	}

	// ------------------------------------------------------------------------

	/**
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
	public function uasort( $comparisonFunction )
	{
		uasort( $this->storage, $comparisonFunction );
	}

	// ------------------------------------------------------------------------

	/**
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
	public function uksort( $comparisonFunction )
	{
		uksort( $this->storage, $comparisonFunction );
	}

	// ------------------------------------------------------------------------

	/**
	 * Sort entries using a "natural order" algorithm
	 *
	 * @link  http://php.net/manual/en/arrayobject.natsort.php
	 * @return void
	 * @since 5.2.0
	 */
	public function natsort()
	{
		natsort( $this->storage );
	}

	// ------------------------------------------------------------------------

	/**
	 * Sort an array using a case insensitive "natural order" algorithm
	 *
	 * @link  http://php.net/manual/en/arrayobject.natcasesort.php
	 * @return void
	 * @since 5.2.0
	 */
	public function natcasesort()
	{
		natcasesort( $this->storage );
	}

	// ------------------------------------------------------------------------

	/**
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
	public function exchangeArray( array $values )
	{
		$oldStorage    = $this->storage;
		$this->storage = $values;

		return $oldStorage;
	}

	// ------------------------------------------------------------------------

	/**
	 * Is Empty
	 *
	 * Determine if the array container is empty
	 *
	 * @return bool
	 */
	public function isEmpty()
	{
		return (bool) empty( $this->storage );
	}

	// ------------------------------------------------------------------------

	/**
	 * Has
	 *
	 * Determine if the value is in array container
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function has( $value )
	{
		return (bool) in_array( $value, $this->storage );
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Array Copy
	 *
	 * Creates a copy of the SplArray classes storage.
	 *
	 * @return array
	 */
	public function getArrayCopy()
	{
		return $this->storage;
	}

	// ------------------------------------------------------------------------

	/**
	 * String representation of object
	 *
	 * @link  http://php.net/manual/en/serializable.serialize.php
	 * @return string the string representation of the object or null
	 * @since 5.1.0
	 */
	public function serialize()
	{
		return serialize( $this->storage );
	}

	// ------------------------------------------------------------------------

	/**
	 * Constructs the object
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
	public function unserialize( $serialized )
	{
		$this->storage = unserialize( $serialized );
	}

	// ------------------------------------------------------------------------

	/**
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
		return count( $this->storage );
	}

	// ------------------------------------------------------------------------

	/**
	 * Specify data which should be serialized to JSON
	 *
	 * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 *        which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	public function jsonSerialize()
	{
		return json_encode( $this->storage, JSON_PRETTY_PRINT );
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve an external iterator
	 *
	 * @link  http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return Traversable An instance of an object implementing <b>Iterator</b> or
	 *        <b>Traversable</b>
	 * @since 5.0.0
	 */
	public function getIterator()
	{
		return new \ArrayIterator( $this->storage );
	}
}