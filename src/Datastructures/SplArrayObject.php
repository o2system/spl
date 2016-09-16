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

use O2System\Spl\Traits\ArrayConversionTrait;
use O2System\Spl\Traits\ArrayFunctionsTrait;

/**
 * O2System Standard PHP Libraries ArrayObject
 *
 * @package O2System\Core\SPL
 */
class SplArrayObject extends \ArrayObject
{
	use ArrayConversionTrait;
	use ArrayFunctionsTrait;

	// ------------------------------------------------------------------------

	/**
	 * SplArrayObject::__construct
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
	 * SplArrayObject::isEmpty
	 *
	 * Checks if the array storage is empty.
	 *
	 * @return bool
	 */
	public function isEmpty()
	{
		return ( $this->count() == 0 ? TRUE : FALSE );
	}

	// -----------------------------------------------------------------------

	/**
	 * SplArrayObject::__get
	 *
	 * @see http://php.net/manual/en/arrayobject.offsetget.php
	 *
	 * @param string $offset The offset with the value.
	 *
	 * @return mixed The value at the specified index or false.
	 */
	public function __get( $offset )
	{
		return $this->offsetGet( $offset );
	}

	// ------------------------------------------------------------------------

	/**
	 * SplArrayObject::exchangeOffset
	 *
	 * Exchange the storage offset into camelcase
	 *
	 * @return array Returns the new array storage
	 */
	public function exchangeOffset()
	{
		if ( $this->count() > 0 )
		{
			$camelcaseStorage = [ ];

			foreach ( $this->getArrayCopy() as $offset => $value )
			{
				$camelcaseStorage[ camelcase( $offset ) ] = $value;
			}

			$this->exchangeArray( $camelcaseStorage );
		}

		return $this->getArrayCopy();
	}

	// ------------------------------------------------------------------------

	/**
	 * SplArrayObject::merge
	 *
	 * Merge array of values into the storage
	 *
	 * @param array $values Variable list of arrays to merge.
	 *
	 * @return array The array merged copy of the resulting array
	 */
	public function merge( array $values )
	{
		$storage = $this->getArrayCopy();
		$storage = array_merge( $storage, $values );

		$this->exchangeArray( $storage );

		return $storage;
	}
}