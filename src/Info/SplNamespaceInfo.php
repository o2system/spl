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
 * Class SplNamespaceInfo
 *
 * @package O2System\Spl\Info
 */
class SplNamespaceInfo
{
    /**
     * Namespace Name
     *
     * @var string
     */
    public $name;

    /**
     * Namespace Paths
     *
     * @var array
     */
    public $paths = [];

    /**
     * SplNamespaceInfo::__construct
     *
     * @param mixed             $namespace
     * @param null|string|array $path
     */
    public function __construct($namespace, $path = null)
    {
        if (is_object($namespace)) {
            $className = get_class($namespace);
            $namespace = pathinfo($className, PATHINFO_DIRNAME);

            $reflection = new \ReflectionClass($className);

            $path = pathinfo($reflection->getFileName(), PATHINFO_DIRNAME);
        }

        $this->name = $namespace;

        if (isset($path)) {
            if (is_string($path)) {
                $this->paths[] = new SplDirectoryInfo($path);
            } elseif (is_array($path)) {
                foreach ($path as $directory) {
                    $this->paths[] = new SplDirectoryInfo($directory);
                }
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * SplNamespaceInfo::__call
     *
     * @param string $method The method name being called
     * @param array  $args   The enumerated array containing the parameters passed to the method call
     *
     * @return mixed|null
     */
    public function __call($method, array $args = [])
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([&$this, $method], $args);
        } elseif (method_exists($this->directoryInfo, $method)) {
            return call_user_func_array([&$this->directoryInfo, $method], $args);
        }

        return null;
    }

    // ------------------------------------------------------------------------

    /**
     * SplNamespaceInfo::getParent
     *
     * Gets the parent namespace.
     *
     * @return string
     */
    public function getParent()
    {
        return str_replace(DIRECTORY_SEPARATOR, '\\', pathinfo($this->name, PATHINFO_DIRNAME)) . '\\';
    }
}