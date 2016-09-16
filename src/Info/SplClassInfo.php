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

namespace O2System\Spl\Info;

// ------------------------------------------------------------------------

/**
 * Class SplClassInfo
 *
 * @package O2System\Spl\Info
 */
class SplClassInfo extends \ReflectionClass
{
	/**
	 * Class Name
	 *
	 * @var string
	 */
	public $name;

	/**
	 * SplFileInfo Instance
	 *
	 * @var \O2System\Spl\Info\SplFileInfo
	 */
	private $fileInfo;

	// ------------------------------------------------------------------------

	/**
	 * SplClassInfo constructor.
	 *
	 * @param mixed $className
	 */
	public function __construct( $className )
	{
		if ( is_object( $className ) )
		{
			$className = get_class( $className );
		}

		if ( class_exists( $className ) )
		{
			parent::__construct( $className );
			$this->fileInfo = new SplFileInfo( $this->getFileName() );
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * SplClassInfo::__call
	 *
	 * @param string $method The method name being called
	 * @param array  $args   The enumerated array containing the parameters passed to the method call
	 *
	 * @return mixed|null
	 */
	public function __call( $method, array $args = [ ] )
	{
		if ( method_exists( $this, $method ) )
		{
			return call_user_func_array( [ &$this, $method ], $args );
		}
		elseif ( method_exists( $this->fileInfo, $method ) )
		{
			return call_user_func_array( [ &$this->fileInfo, $method ], $args );
		}

		return NULL;
	}
}