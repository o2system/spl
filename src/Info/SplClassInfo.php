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

namespace O2System\Spl\Info;

// ------------------------------------------------------------------------

/**
 * Class SplClassInfo
 *
 * @package O2System\Spl\Info
 */
class SplClassInfo
{
    /**
     * SplClassInfo::$name
     *
     * @var string
     */
    public $name;

    /**
     * SplClassInfo::$reflection
     *
     * @var \ReflectionClass
     */
    protected $reflection;

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
            $this->name = $className;
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

        return dash(end($parts));
    }

    // ------------------------------------------------------------------------

    /**
     * SplClassInfo::getReflection
     * 
     * @return \ReflectionClass
     * @throws \ReflectionException
     */
    public function getReflection()
    {
        if (empty($this->name)) {
            throw new \RuntimeException('Internal error: SplClassInfo failed to retrieve the reflection object');
        }

        if(empty($this->reflection)) {
            $this->reflection = new \ReflectionClass($this->name);
        }

        return $this->reflection;
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

        return new SplNamespaceInfo($this->name, $this->getReflection()->getFileName());
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

    // ------------------------------------------------------------------------

    /**
     * SplClassInfo::__call
     *
     * @param string  $method
     * @param array   $args
     *
     * @return mixed
     */
    public function __call($method, array $args = [])
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $args);
        } else {
            $reflection = $this->getReflection();

            if(method_exists($reflection, $method)) {
                return call_user_func_array([$reflection, $method], $args);
            }
        }
    }
}