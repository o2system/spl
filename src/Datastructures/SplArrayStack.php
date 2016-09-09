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

use O2System\Spl\Interfaces\SplArrayInterface;

/**
 * Class SplArrayStack
 *
 * The SplStack class provides the main functionalities of a stack implemented using a doubly linked list and
 * the iterator mode is based on LIFO (Last In First Out).
 *
 * @package O2System\Spl\Datastructures
 */
class SplArrayStack extends \SplStack implements SplArrayInterface
{
	/**
	 * SplArrayStack constructor.
	 *
	 * @param array $stack
	 */
	public function __construct( array $stack = [ ] )
	{
		if ( count( $stack ) )
		{
			foreach ( $stack as $item )
			{
				$this->push( $item );
			}
		}
	}

	// -----------------------------------------------------------------------

	/**
	 * Current
	 *
	 * Replacement for \SplStack current method
	 *
	 * @return mixed
	 */
	public function current()
	{
		if ( NULL === ( $current = parent::current() ) )
		{
			$this->rewind();
		}

		return parent::current();
	}

	// -----------------------------------------------------------------------

	/**
	 * Is Empty
	 *
	 * Determine if the array container is empty
	 *
	 * @return bool
	 */
	public function isEmpty()
	{
		return ( $this->count() == 0 ? TRUE : FALSE );
	}

	// -----------------------------------------------------------------------

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
		return in_array( $value, $this->getArrayCopy() );
	}

	// -----------------------------------------------------------------------

	/**
	 * Get Array Copy
	 *
	 * @return array
	 */
	public function getArrayCopy()
	{
		$arrayCopy = [ ];

		foreach ( $this as $key => $value )
		{
			$arrayCopy[ $key ] = $value;
		}

		return $arrayCopy;
	}
}