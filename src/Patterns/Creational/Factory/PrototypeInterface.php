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

namespace O2System\Spl\Patterns\Creational\Factory;

/**
 * Interface PrototypeInterface
 * @package O2System\Spl\Patterns\Creational\Factory
 */
interface PrototypeInterface
{
    /**
     * PrototypeInterface::create
     *
     * @param array $config
     *
     * @return mixed
     */
    public function create(array $config = []);
}