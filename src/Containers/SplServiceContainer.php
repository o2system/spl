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

namespace O2System\Spl\Containers;

// ------------------------------------------------------------------------

use Psr\Container\ContainerInterface;
use O2System\Spl\Containers\DataStructures\SplServiceRegistry;

/**
 * Class SplServiceContainer
 *
 * @package O2System\Spl\Dependency
 */
class SplServiceContainer implements \Countable, ContainerInterface
{
    /**
     * Inversion Control Closure Container
     *
     * @var array
     */
    private $services = [];

    // ------------------------------------------------------------------------

    /**
     * SplServiceContainer::service
     *
     * Adds an service object into the services container.
     *
     * @param string             $offset
     * @param SplServiceRegistry $service
     */
    public function attach($offset, SplServiceRegistry $service)
    {
        $this->services[ $offset ] = $service;
    }

    // ------------------------------------------------------------------------

    /**
     * SplServiceContainer::__unset
     *
     * A convenient way to removes a specific service object
     * by doing unset( $services->offset )
     *
     * @param string $offset
     */
    public function __unset($offset)
    {
        $this->detach($offset);
    }

    // ------------------------------------------------------------------------

    /**
     * SplServiceContainer::detach
     *
     * Removes a specific service object
     *
     * @param string $offset
     */
    public function detach($offset)
    {
        if (isset($this->services[ $offset ])) {
            unset($this->services[ $offset ]);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * SplServiceContainer::__isset
     *
     * A convenient way to checks if the container has a specific service object,
     * by doing isset( $services->offset )
     *
     * @param string $offset
     *
     * @return bool
     */
    public function __isset($offset)
    {
        return $this->has($offset);
    }

    // ------------------------------------------------------------------------

    /**
     * SplServiceContainer::has
     *
     * Checks if the registry contains a specific service object.
     *
     * @param string $offset
     *
     * @return bool
     */
    public function has($offset)
    {
        return (bool)isset($this->services[ $offset ]);
    }

    // ------------------------------------------------------------------------

    /**
     * SplServiceContainer::__get
     *
     * A convenient way to access the specific service object,
     * by doing $services->offset
     *
     * @param string $offset
     *
     * @return bool
     */
    public function &__get($offset)
    {
        $get[ $offset ] = $this->get($offset);

        return $get[ $offset ];
    }

    // ------------------------------------------------------------------------

    /**
     * SplServiceContainer::get
     *
     * Returns the service object.
     *
     * @param string $offset
     * @param array  $arguments
     *
     * @return mixed Returns FALSE when calling the service is failed.
     */
    public function &get($offset, array $arguments = [])
    {
        $get[ $offset ] = false;

        if ($this->has($offset)) {
            $service = $this->services[ $offset ];

            if ($service instanceof SplServiceRegistry) {
                if (empty($arguments)) {
                    return $service->getInstance();
                } else {
                    if ($service->hasMethod('__construct')) {
                        $newServiceInstance = $service->newInstanceArgs($arguments);
                    } else {
                        $newServiceInstance = $service->getInstance();
                    }

                    if ($DocComment = $service->getDocComment()) {
                        preg_match_all('/@inject\s(.*)/', $DocComment, $matches);

                        if (count($matches[ 1 ])) {
                            foreach ($matches[ 1 ] as $className) {
                                $className = trim($className, '\\');
                                $className = trim($className);

                                $map = strtolower(get_class_name($className));

                                if (isset($this->map[ $className ])) {
                                    $map = $this->map[ $className ];
                                }

                                $variable = $map;
                                $object =& $this->get($map);

                                preg_match_all('/[$](.*)\s(.*)/', trim($className), $classMatches);

                                if (count($classMatches[ 1 ])) {
                                    $variable = $classMatches[ 1 ][ 0 ];
                                }

                                $setterMethod = ucwords(str_replace(['-', '_'], ' ', $variable));
                                $setterMethod = str_replace(' ', '', $setterMethod);
                                $setterMethod = 'set' . $setterMethod;

                                if (method_exists($newServiceInstance, $setterMethod)) {
                                    $newServiceInstance->{$setterMethod}($object);
                                } elseif (method_exists($newServiceInstance, '__set')) {
                                    $newServiceInstance->__set($variable, $object);
                                } else {
                                    $newServiceInstance->{$variable} =& $object;
                                }
                            }
                        }
                    }

                    $get[ $offset ] = $newServiceInstance;
                }
            }
        }

        return $get[ $offset ];
    }

    // ------------------------------------------------------------------------

    /**
     * SplServiceContainer::count
     *
     * Count elements of an object
     *
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     *        </p>
     *        <p>
     *        The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->services);
    }
}