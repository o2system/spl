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

namespace O2System\Spl\DataStructures;

// ------------------------------------------------------------------------

use O2System\Spl\Interfaces\SplArrayInterface;

/**
 * Class SplArrayStack
 *
 * The SplStack class provides the main functionalities of a stack implemented using a doubly linked list and
 * the iterator mode is based on LIFO (Last In First Out).
 *
 * @package O2System\Spl\DataStructures
 */
class SplArrayStack extends \SplStack implements SplArrayInterface
{
    /**
     * SplArrayStack::__construct
     *
     * @param array $stack
     */
    public function __construct(array $stack = [])
    {
        if (count($stack)) {
            foreach ($stack as $item) {
                $this->push($item);
            }
        }
    }

    // -----------------------------------------------------------------------

    /**
     * SplArrayStack::isEmpty
     *
     * Checks if the array storage is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return ($this->count() == 0 ? true : false);
    }

    // -----------------------------------------------------------------------

    /**
     * SplArrayStack::has
     *
     * Checks if a value exists in the storage.
     *
     * @param mixed $needle The searched value.
     * @param bool  $strict If the third parameter strict is set to TRUE then the in_array() function will also check
     *                      the types of the needle in the haystack.
     *
     * @return bool
     */
    public function has($needle, $strict = false)
    {
        return in_array($needle, $this->getArrayCopy(), $strict);
    }

    // -----------------------------------------------------------------------

    /**
     * SplArrayStack::getArrayCopy
     *
     * Creates a copy of the storage.
     *
     * @return array A copy of the storage.
     */
    public function getArrayCopy()
    {
        $arrayCopy = [];

        for ($this->rewind(); $this->valid(); $this->next()) {
            $arrayCopy[] = $this->current();
        }

        return $arrayCopy;
    }
}