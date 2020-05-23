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
use O2System\Kernel\DataStructures\Config;

/**
 * Class ConfigCollectorTrait
 *
 * @package O2System\Spl\Traits\Collectors
 */
trait ConfigCollectorTrait
{
    /**
     * List of Config
     *
     * @type array
     */
    protected $config = [];

    /**
     * Add Config
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function addConfig($key, $value)
    {
        if (isset($this->config[ $key ])) {
            if (is_array($value) AND is_array($this->config[ $key ])) {
                $this->config[ $key ] = array_merge($this->config[ $key ], $value);
            } else {
                $this->config[ $key ] = $value;
            }
        } else {
            $this->config[ $key ] = $value;
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Get Config
     *
     * @access  public
     * @final   this method can't be overwritten
     *
     * @param string|null $key Config item index name
     *
     * @return mixed
     */
    final public function getConfig($key = null, $offset = null)
    {
        if (isset($key)) {
            if (isset($this->config[ $key ])) {
                if (isset($offset)) {
                    return isset($this->config[ $key ][ $offset ]) ? $this->config[ $key ][ $offset ] : null;
                }

                return $this->config[ $key ];
            }

            return false;
        }

        return $this->config;
    }

    // ------------------------------------------------------------------------

    /**
     * Set Config
     *
     * @access   public
     *
     * @param array|string $key
     *
     * @return static
     */
    public function setConfig($key, $value = null)
    {
        if (is_array($key)) {
            if (empty($this->config)) {
                $this->config = $key;
            } else {
                $this->config = array_merge($this->config, $key);
            }
        } elseif ($key instanceof Config) {
            $this->config = $key;
        } elseif (isset($this->config[ $key ])) {
            if (is_array($value) AND is_array($this->config[ $key ])) {
                $this->config[ $key ] = array_merge($this->config[ $key ], $value);
            } else {
                $this->config[ $key ] = $value;
            }
        } else {
            $this->config[ $key ] = $value;
        }

        return $this;
    }
}