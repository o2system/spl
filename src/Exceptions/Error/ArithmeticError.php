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

use O2System\Spl\Exceptions\ErrorException;

/**
 * Class ArithmeticError
 *
 * ArithmeticError is thrown when an error occurs while performing mathematical operations.
 * In PHP 7.0, these errors include attempting to perform a bitshift by a negative amount,
 * and any call to intdiv() that would result in a value outside the possible bounds of an integer.
 *
 * @see     http://php.net/manual/en/class.arithmeticerror.php
 *
 * @package O2System\Spl\Exceptions\Logic\Error
 */
class ArithmeticError extends ErrorException
{

}