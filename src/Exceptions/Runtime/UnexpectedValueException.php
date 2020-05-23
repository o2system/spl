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

namespace O2System\Spl\Exceptions\Runtime;

// ------------------------------------------------------------------------

use O2System\Spl\Exceptions\RuntimeException;

/**
 * Class UnexpectedValueException
 *
 * Exception thrown if a value does not match with a set of values.
 * Typically this happens when a function calls another function and expects
 * the return value to be of a certain type or value not including arithmetic or buffer related errors.
 *
 * @see     http://php.net/manual/en/class.unexpectedvalueexception.php
 *
 * @package O2System\Spl\Exceptions\Runtime
 */
class UnexpectedValueException extends RuntimeException
{

}