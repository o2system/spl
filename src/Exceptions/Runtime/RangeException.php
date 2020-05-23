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
 * Class RangeException
 *
 * Exception thrown to indicate range errors during program execution.
 * Normally this means there was an arithmetic error other than under/overflow.
 * This is the runtime version of DomainException.
 *
 * @see     http://php.net/manual/en/class.rangeexception.php
 *
 * @package O2System\Spl\Exceptions\Runtime
 */
class RangeException extends RuntimeException
{

}