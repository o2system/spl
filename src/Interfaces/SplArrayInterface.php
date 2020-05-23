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

namespace O2System\Spl\Interfaces;

// ------------------------------------------------------------------------

/**
 * Interface SplArrayInterface
 *
 * @package O2System\Spl\Interfaces
 */
interface SplArrayInterface
{
    /**
     * SplArrayInterface::isEmpty
     *
     * Checks if the array storage is empty.
     *
     * @return bool
     */
    public function isEmpty();

    // ------------------------------------------------------------------------

    /**
     * SplArrayInterface::has
     *
     * Checks if a value exists in the storage.
     *
     * @param mixed $needle The searched value.
     * @param bool  $strict If the third parameter strict is set to TRUE then the in_array() function will also check
     *                      the types of the needle in the haystack.
     *
     * @return bool
     */
    public function has($needle, $strict = false);

    // ------------------------------------------------------------------------

    /**
     * SplArrayInterface::getArrayCopy
     *
     * Creates a copy of the storage.
     *
     * @return array A copy of the storage.
     */
    public function getArrayCopy();
}