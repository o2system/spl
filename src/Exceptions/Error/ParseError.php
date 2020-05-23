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
 * Class ParseError
 *
 * ParseError is thrown when an error occurs while parsing PHP code, such as when eval() is called.
 *
 * @see     http://php.net/manual/en/class.parseerror.php
 *
 * @package O2System\Spl\Exceptions\Logic\Error
 */
class ParseError extends ErrorException
{

}