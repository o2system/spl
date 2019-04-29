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

namespace O2System\Spl\Patterns\Structural\Assemble;

/**
 * Class AbstractAssemble
 * @package O2System\Spl\Patterns\Assemble
 */
abstract class AbstractAssemble implements CollectorInterface
{
    protected $collection = [];

    public function collect()
    {

    }

    public function &getCollection($offset)
    {

    }
}