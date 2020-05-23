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

namespace O2System\Spl\Patterns\Structural\Provider;

/**
 * Interface RegistryInterface
 * @package O2System\Spl\Patterns\Structural\Provider
 */
interface RegistryInterface
{
    /**
     * RegistryInterface::register
     *
     * Register the object into the class container.
     *
     * @param object $object The object to be contained.
     * @param string $offset The object container array offset key.
     *
     * @return void
     */
    public function register($object, $offset = null);
}