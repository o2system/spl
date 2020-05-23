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

namespace O2System\Spl\Exceptions;

// ------------------------------------------------------------------------

use O2System\Spl\Exceptions\Abstracts\AbstractException;

/**
 * Class LogicException
 *
 * Exception that represents error in the program logic.
 * This kind of exception should lead directly to a fix in your code.
 *
 * @see     http://php.net/manual/en/class.logicexception.php
 *
 * @package O2System\Spl\Exceptions
 */
class LogicException extends AbstractException
{

}