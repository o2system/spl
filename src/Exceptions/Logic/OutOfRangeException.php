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

namespace O2System\Spl\Exceptions\Logic;

// ------------------------------------------------------------------------

use O2System\Spl\Exceptions\LogicException;

/**
 * Class OutOfRangeException
 *
 * Exception thrown when an illegal index was requested.
 * This represents errors that should be detected at compile time.
 *
 * @see     http://php.net/manual/en/class.outofrangeexception.php
 *
 * @package O2System\Spl\Exceptions\Logic
 */
class OutOfRangeException extends LogicException
{

}