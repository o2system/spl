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
 * Class BadFunctionCallException
 *
 * Exception thrown if a callback refers to an undefined function or if some arguments are missing.
 *
 * @see     http://php.net/manual/en/class.badfunctioncallexception.php
 *
 * @package O2System\Spl\Exceptions\Logic
 */
class BadFunctionCallException extends LogicException
{

}