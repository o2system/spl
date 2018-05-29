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

namespace O2System\Spl\Info;

// ------------------------------------------------------------------------

/**
 * Class SplClassInfo
 *
 * @package O2System\Spl\Info
 */
class SplClassInfo extends \ReflectionClass
{
    /**
     * Class Name
     *
     * @var string
     */
    public $name;

    // ------------------------------------------------------------------------

    /**
     * SplClassInfo constructor.
     *
     * @param mixed $className
     */
    public function __construct($className)
    {
        if (is_object($className)) {
            $className = get_class($className);
        }

        if (class_exists($className)) {
            parent::__construct($className);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * SplClassInfo::getClass
     *
     * Gets class name.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->name;
    }

    // ------------------------------------------------------------------------

    /**
     * SplClassInfo::getParameter
     *
     * Gets class name.
     *
     * @return string
     */
    public function getParameter()
    {
        $parts = explode('\\', $this->name);

        return strtolower(end($parts));
    }

    // ------------------------------------------------------------------------

    /**
     * SplClassInfo::getFileInfo
     *
     * Gets class file info metadata.
     *
     * @return \O2System\Spl\Info\SplNamespaceInfo
     */
    public function getNamespaceInfo()
    {
        if (empty($this->name)) {
            throw new \RuntimeException('Internal error: SplClassInfo failed to retrieve the reflection object');
        }

        return new SplNamespaceInfo($this->name, $this->getFileName());
    }

    // ------------------------------------------------------------------------

    /**
     * SplClassInfo::getFileInfo
     *
     * Gets class file info metadata.
     *
     * @return \O2System\Spl\Info\SplFileInfo
     */
    public function getFileInfo()
    {
        if (empty($this->name)) {
            throw new \RuntimeException('Internal error: SplClassInfo failed to retrieve the reflection object');
        }

        return new SplFileInfo($this->getFileName());
    }
}