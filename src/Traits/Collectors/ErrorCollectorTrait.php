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
    public function setErrors(array $errors)
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
     * ErrorCollectorTrait::getLatestErrorMessage
     *
     * Returns latest error message.
     *
     * @return string|bool Returns FALSE if Failed.
     */
    public function getLatestErrorMessage()
    {
        if (count($this->errors)) {
            return end($this->errors);
        }

        return false;
    }

    // ------------------------------------------------------------------------

    /**
     * ErrorCollectorTrait::getLatestErrorCode
     *
     * Returns latest error code.
     *
     * @return int|bool Returns FALSE if Failed.
     */
    public function getLatestErrorCode()
    {
        if (count($this->errors)) {
            end($this->errors);

            return key($this->errors);
        }

        return false;
    }

    // ------------------------------------------------------------------------

    /**
     * ErrorCollectorTrait::addErrors
     *
     * Adds errors.
     *
     * @param array $errors
     */
    public function addErrors(array $errors)
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
    public function addError($code, $message)
    {
        if(class_exists('\O2System\Kernel')) {
            $this->errors[ $code ] = language($message);
        } else {
            $this->errors[ $code ] = $message;
        }
    }
}