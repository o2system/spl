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

namespace O2System\Spl\Exceptions\Abstracts;

// ------------------------------------------------------------------------

use O2System\Spl\Info\SplClassInfo;

/**
 * Class Exception
 *
 * @package O2System\Kernel
 */
abstract class AbstractException extends \Exception
{
    /**
     * Exception Header
     *
     * @var string
     */
    protected $header;

    /**
     * Exception Description
     *
     * @var string
     */
    protected $description;

    /**
     * Exception View
     *
     * @var string
     */
    protected $view = 'exception';

    // ------------------------------------------------------------------------

    /**
     * Exception::__construct
     *
     * @param string          $message
     * @param int             $code
     * @param array           $context
     * @param \Exception|NULL $previous
     */
    public function __construct($message, $code = 0, array $context = [], \Exception $previous = null)
    {
        if (class_exists('O2System\Kernel', false)) {
            $classInfo = new SplClassInfo($this);
            $classNameParts = explode('\\', $classInfo->getClass());
            $classParameter = strtolower(end($classNameParts));
            $classLanguageDirectory = dirname($classInfo->getFileInfo()->getRealPath()) . DIRECTORY_SEPARATOR . 'Languages' . DIRECTORY_SEPARATOR;

            if (false !== ($exceptionKey = array_search('Exception', $classNameParts)) OR
                false !== ($exceptionKey = array_search('Exceptions', $classNameParts))
            ) {
                if (isset($classNameParts[ $exceptionKey - 1 ])) {
                    $classParameter = $classNameParts[ $exceptionKey - 1 ];

                }
            }

            $this->view = strtolower($classParameter . '_' . $this->view);
            $languageFilename = strtolower($classParameter) . '_' . language()->getDefault() . '.ini';
            $languageKey = strtoupper($classParameter . '_exception');
            language()->loadFile($classLanguageDirectory . $languageFilename);

            $this->header = language()->getLine('E_HEADER_' . $languageKey);
            $this->description = language()->getLine('E_DESCRIPTION_' . $languageKey);
            $message = language()->getLine($message, $context);
        }

        parent::__construct($message, $code, $previous);
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractException::getHeader
     *
     * Gets exception header.
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractException::getDescription
     *
     * Gets exception description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractException::getChronology
     *
     * @return array
     */
    public function getChronology()
    {
        if (class_exists('O2System\Gear\Trace')) {
            return (new \O2System\Gear\Trace($this->getTrace()))->getChronology();
        }

        return $this->getTrace();
    }

    // ------------------------------------------------------------------------

    /**
     * AbstractException::getView
     *
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }
}