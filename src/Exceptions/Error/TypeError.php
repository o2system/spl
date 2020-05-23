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

namespace O2System\Spl\Exceptions\Error;

// ------------------------------------------------------------------------

use O2System\Spl\Exceptions\ErrorException;

/**
 * Class TypeError
 *
 * There are three scenarios where a TypeError may be thrown.
 * The first is where the argument type being passed to a function does not match
 * its corresponding declared parameter type. The second is where a value being returned
 * from a function does not match the declared function return type. The third is where
 * an invalid number of arguments are passed to a built-in PHP function (strict mode only).
 *
 * @see     http://php.net/manual/en/class.typeerror.php
 *
 * @package O2System\Spl\Exceptions\Logic\Error
 */
class TypeError extends ErrorException
{

}