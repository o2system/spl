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

namespace O2System\Spl\Datastructures;

// ------------------------------------------------------------------------

/**
 * O2System Standard PHP Libraries ArrayObject
 *
 * @package O2System\Core\SPL
 */
class SplArrayObject extends \ArrayObject
{
	/**
	 * Trait array conversion functions
	 */
	use Traits\ArrayConversionTrait;

	/**
	 * Trait array manipulations functions
	 */
	use Traits\ArrayFunctionsTrait;

	// ------------------------------------------------------------------------

	/**
	 * SplArrayObject constructor.
	 *
	 * @param array $array
	 * @param int   $flag
	 */
	public function __construct( array $array = [ ], $flag = \ArrayObject::ARRAY_AS_PROPS )
	{
		parent::__construct( $array, $flag );
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic method __get
	 *
	 * @param string $offset
	 *
	 * @return mixed
	 */
	public function __get( $offset )
	{
		return $this->offsetGet( $offset );
	}

	// ------------------------------------------------------------------------

	/**
	 * Offset Camelcase
	 *
	 * Perform offset key conversion into camelcase
	 *
	 * @return void
	 */
	public function offsetCamelcase()
	{
		if ( $this->count() > 0 )
		{
			$camelcaseStorage = [];

			foreach ( $this->getArrayCopy() as $offset => $value )
			{
				$camelcaseStorage[ camelcase( $offset ) ] = $value;
			}

			$this->exchangeArray( $camelcaseStorage );
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Merge
	 *
	 * Merge array into storage
	 *
	 * @param array $values
	 */
	public function merge( $values )
	{
		$storage = $this->getArrayCopy();
		$storage = array_merge( $storage, $values );

		$this->exchangeArray( $storage );
	}
}