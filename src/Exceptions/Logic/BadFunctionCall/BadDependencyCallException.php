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

namespace O2System\Spl\Exceptions\Logic\BadFunctionCall;

// ------------------------------------------------------------------------

use O2System\Spl\Exceptions\Logic\BadFunctionCallException;

/**
 * Class BadDependencyCallException
 *
 * Exception thrown if a callback refers to unloaded dependency library class.
 *
 * @package O2System\Spl\Exceptions\Logic\BadFunctionCall
 */
class BadDependencyCallException extends BadFunctionCallException
{

}