<?php
/**
 * This file is part of the O2System PHP Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author         Steeve Andrian Salim
 * @copyright      Copyright (c) Steeve Andrian Salim
 */

// ------------------------------------------------------------------------

namespace O2System\Spl\Traits\Collectors;

// ------------------------------------------------------------------------

/**
 * Trait ErrorCollectorTrait
 * @package O2System\Spl\Traits\Collectors
 */
trait ErrorCollectorTrait
{
    /**
     * ErrorCollectorTrait::$errors
     *
     * List of errors.
     *
     * @var array
     */
    protected $errors = [];

    // ------------------------------------------------------------------------

    /**
     * ErrorCollectorTrait::getErrors
     *
     * Gets errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    // ------------------------------------------------------------------------

    /**
     * ErrorCollectorTrait::setErrors
     *
     * Sets errors.
     *
     * @param array $errors
     */
    protected function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    // ------------------------------------------------------------------------

    /**
     * ErrorCollectorTrait::hasErrors
     *
     * @return bool
     */
    public function hasErrors()
    {
        return (bool)count($this->errors) ? true : false;
    }

    // ------------------------------------------------------------------------

    /**
     * ErrorCollectorTrait::addErrors
     *
     * Adds errors.
     *
     * @param array $errors
     */
    protected function addErrors(array $errors)
    {
        foreach ($errors as $code => $message) {
            $this->addError($code, $message);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * ErrorCollectorTrait::addError
     *
     * Add error.
     *
     * @param int    $code    Error code.
     * @param string $message Error message.
     */
    protected function addError($code, $message)
    {
        $this->errors[ $code ] = $message;
    }
}