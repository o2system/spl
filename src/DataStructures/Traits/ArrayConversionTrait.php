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

namespace O2System\Spl\DataStructures\Traits;

// ------------------------------------------------------------------------

use O2System\Spl\DataStructures\SplArrayObject;

/**
 * Trait ArrayConversionTrait
 *
 * Add re-usable ArrayObject conversion methods
 *
 * @package O2System\Spl\Traits
 */
trait ArrayConversionTrait
{
    /**
     * ArrayConversionTrait::__toObject
     *
     * Convert storage array into ArrayObject
     *
     * @param int $depth The depth of the conversion
     *
     * @return SplArrayObject
     */
    public function __toObject($depth = 0)
    {
        return $this->___toObjectIterator($this->getArrayCopy(), ($depth == 0 ? 'ALL' : $depth));
    }

    // --------------------------------------------------------------------

    /**
     * ArrayConversionTrait::__toObjectIterator
     *
     * Iterate storage array into object
     *
     * @param array  $array   The array copy
     * @param string $depth   The depth of the conversion
     * @param int    $counter Internal iterator counter
     *
     * @return SplArrayObject
     */
    private function ___toObjectIterator($array, $depth = 'ALL', $counter = 0)
    {
        $object = new SplArrayObject();

        if ($this->count() > 0) {
            foreach ($array as $key => $value) {
                if (strlen($key)) {
                    if (is_array($value)) {
                        if ($depth == 'ALL') {
                            $object->offsetSet($key, $this->___toObjectIterator($value, $depth));
                        } elseif (is_numeric($depth)) {
                            if ($counter != $depth) {
                                $object->offsetSet($key, $this->___toObjectIterator($value, $depth, $counter));
                            } else {
                                $object->offsetSet($key, $value);
                            }
                        } elseif (is_string($depth) && $key == $depth) {
                            $object->offsetSet($key, $value);
                        } elseif (is_array($depth) && in_array($key, $depth)) {
                            $object->offsetSet($key, $value);
                        } else {
                            $object->offsetSet($key, $this->___toObjectIterator($value, $depth));
                        }
                    } else {
                        $object->offsetSet($key, $value);
                    }
                }
            }
        }

        return $object;
    }

    // --------------------------------------------------------------------

    /**
     * ArrayConversionTrait::__toString
     *
     * Returning JSON Encode array copy of the storage
     *
     * @return string
     */
    public function __toString()
    {
        if (method_exists($this, 'render')) {
            return $this->render();
        }

        return $this->__toJSON();
    }

    // ------------------------------------------------------------------------

    /**
     * ArrayConversionTrait::__toJSON
     *
     * @see http://php.net/manual/en/function.json-encode.php
     *
     * @param int $options JSON encode options, default JSON_PRETTY_PRINT
     * @param int $depth   Maximum depth of JSON encode. Must be greater than zero.
     *
     * @return string
     */
    public function __toJson($options = JSON_PRETTY_PRINT, $depth = 512)
    {
        $depth = $depth == 0 ? 512 : $depth;

        return call_user_func_array('json_encode', [$this->getArrayCopy(), $options, $depth]);
    }

    // --------------------------------------------------------------------

    /**
     * ArrayConversionTrait::__toSerialize
     *
     * Convert rows into PHP serialize array
     *
     * @see http://php.net/manual/en/function.serialize.php
     *
     * @return string
     */
    public function __toSerialize()
    {
        return serialize($this->__toArray());
    }

    // --------------------------------------------------------------------

    /**
     * ArrayConversionTrait::__toArray
     *
     * Returning array copy of the storage
     *
     * @return string
     */
    public function __toArray()
    {
        return $this->getArrayCopy();
    }

    // --------------------------------------------------------------------

    /**
     * ArrayConversionTrait::implode
     *
     * Join the storage elements with a string
     *
     * @param string $glue Defaults to an empty string.
     *
     * @return string
     */
    public function implode($glue = '')
    {
        return implode($glue, $this->getArrayCopy());
    }

    // --------------------------------------------------------------------

    /**
     * ArrayConversionTrait::join
     *
     * Join the storage elements with a string
     *
     * @param string $glue Defaults to an empty string.
     *
     * @return string
     */
    public function join($glue = '')
    {
        return join($glue, $this->getArrayCopy());
    }
}