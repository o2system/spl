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

use O2System\Spl\Datastructures\SplArrayObject;

/**
 * Trait ArrayConversionTrait
 *
 * Add re-usable ArrayObject conversion methods
 *
 * @package O2System\Spl\Traits
 */
trait ArrayConversionTrait
{
	/**
	 * __toObject
	 *
	 * Convert storage array into ArrayObject
	 *
	 * @param int $depth
	 *
	 * @return SplArrayObject
	 */
	public function __toObject( $depth = 0 )
	{
		return $this->___toObjectIterator( $this->getArrayCopy(), ( $depth == 0 ? 'ALL' : $depth ) );
	}

	// --------------------------------------------------------------------

	/**
	 * __toObjectIterator
	 *
	 * Iterate storage array into object
	 *
	 * @param        $array
	 * @param string $depth
	 * @param int    $counter
	 *
	 * @return SplArrayObject
	 */
	private function ___toObjectIterator( $array, $depth = 'ALL', $counter = 0 )
	{
		$object = new SplArrayObject();

		if ( $this->count() > 0 )
		{
			foreach ( $array as $key => $value )
			{
				if ( strlen( $key ) )
				{
					if ( is_array( $value ) )
					{
						if ( $depth == 'ALL' )
						{
							$object->offsetSet( $key, $this->___toObjectIterator( $value, $depth ) );
						}
						elseif ( is_numeric( $depth ) )
						{
							if ( $counter != $depth )
							{
								$object->offsetSet( $key, $this->___toObjectIterator( $value, $depth, $counter ) );
							}
							else
							{
								$object->offsetSet( $key, $value );
							}
						}
						elseif ( is_string( $depth ) && $key == $depth )
						{
							$object->offsetSet( $key, $value );
						}
						elseif ( is_array( $depth ) && in_array( $key, $depth ) )
						{
							$object->offsetSet( $key, $value );
						}
						else
						{
							$object->offsetSet( $key, $this->___toObjectIterator( $value, $depth ) );
						}
					}
					else
					{
						$object->offsetSet( $key, $value );
					}
				}
			}
		}

		return $object;
	}

	// --------------------------------------------------------------------

	/**
	 * __toString
	 *
	 * Returning JSON Encode array copy of storage ArrayObject
	 *
	 * @return string
	 */
	public function __toString()
	{
		if ( method_exists( $this, 'render' ) )
		{
			return $this->render();
		}

		return json_encode( $this->getArrayCopy() );
	}

	// ------------------------------------------------------------------------

	/**
	 * __toJSON
	 *
	 * @see http://php.net/manual/en/function.json-encode.php
	 *
	 * @param int $options JSON encode options, default JSON_PRETTY_PRINT
	 * @param int $depth   Maximum depth of JSON encode. Must be greater than zero.
	 *
	 * @return string
	 */
	public function __toJSON( $options = JSON_PRETTY_PRINT, $depth = 512 )
	{
		$depth = $depth == 0 ? 512 : $depth;

		return call_user_func_array( 'json_encode', [ $this->getArrayCopy(), $options, $depth ] );
	}

	// --------------------------------------------------------------------

	/**
	 * __toSerialize
	 *
	 * Convert rows into PHP serialize array
	 *
	 * @see http://php.net/manual/en/function.serialize.php
	 *
	 * @param int $options JSON encode options, default JSON_PRETTY_PRINT
	 * @param int $depth   Maximum depth of JSON encode. Must be greater than zero.
	 *
	 * @return string
	 */
	public function __toSerialize()
	{
		return serialize( $this->__toArray() );
	}

	// --------------------------------------------------------------------

	/**
	 * __toArray
	 *
	 * Returning array copy of storage ArrayObject
	 *
	 * @return string
	 */
	public function __toArray()
	{
		return $this->getArrayCopy();
	}

	// --------------------------------------------------------------------

	/**
	 * Implode
	 *
	 * Flatten array with glue
	 *
	 * @param $glue
	 *
	 * @return string
	 */
	public function implode( $glue = '' )
	{
		return implode( $glue, $this->getArrayCopy() );
	}

	// --------------------------------------------------------------------

	/**
	 * Join
	 *
	 * Flatten array with glue
	 *
	 * @param $glue
	 *
	 * @return string
	 */
	public function join( $glue = '' )
	{
		return join( $glue, $this->getArrayCopy() );
	}
}