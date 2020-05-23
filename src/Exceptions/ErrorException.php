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
 * Class ErrorException
 *
 * ErrorException is the wrapper class of the predefined exceptions PHP Error class.
 *
 * @see     http://php.net/manual/en/class.error.php
 *
 * @package O2System\Spl\Exceptions\Logic
 */
class ErrorException extends AbstractException
{
    /**
     * ErrorException::$severity
     *
     * The severity of the error exception.
     *
     * @var int
     */
    protected $severity;

    // ------------------------------------------------------------------------

    /**
     * ErrorException::__construct
     *
     * @param string          $message
     * @param array|int       $severity
     * @param string          $filename
     * @param int             $line
     * @param \Exception|null $previous
     */
    public function __construct(
        $message = '',
        $severity = 1,
        $filename = '',
        $line = 0,
        $context = []
    ) {
        $this->severity = $severity;
        $this->file = $filename;
        $this->line = $line;

        if (class_exists('O2System\Kernel', false)) {
            if (is_array($context)) {
                $message = language()->getLine($message, $context);
            } else {
                $message = language()->getLine($message);
            }
        }

        parent::__construct($message, 0, []);
    }

    // ------------------------------------------------------------------------

    /**
     * ErrorException::getSeverity
     *
     * Gets the exception severity.
     *
     * @return int
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    // ------------------------------------------------------------------------

    /**
     * ErrorException::getStringSeverity
     *
     * Gets the exception severity string.
     *
     * @return string
     */
    public function getStringSeverity()
    {
        switch ($this->severity) {
            case E_ERROR: // 1 //
                return 'E_ERROR';
            case E_WARNING: // 2 //
                return 'E_WARNING';
            case E_PARSE: // 4 //
                return 'E_PARSE';
            case E_NOTICE: // 8 //
                return 'E_NOTICE';
            case E_CORE_ERROR: // 16 //
                return 'E_CORE_ERROR';
            case E_CORE_WARNING: // 32 //
                return 'E_CORE_WARNING';
            case E_COMPILE_ERROR: // 64 //
                return 'E_COMPILE_ERROR';
            case E_COMPILE_WARNING: // 128 //
                return 'E_COMPILE_WARNING';
            case E_USER_ERROR: // 256 //
                return 'E_USER_ERROR';
            case E_USER_WARNING: // 512 //
                return 'E_USER_WARNING';
            case E_USER_NOTICE: // 1024 //
                return 'E_USER_NOTICE';
            case E_STRICT: // 2048 //
                return 'E_STRICT';
            case E_RECOVERABLE_ERROR: // 4096 //
                return 'E_RECOVERABLE_ERROR';
            case E_DEPRECATED: // 8192 //
                return 'E_DEPRECATED';
            case E_USER_DEPRECATED: // 16384 //
                return 'E_USER_DEPRECATED';
        }

        return '';
    }
}