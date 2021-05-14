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

namespace O2System\Spl\Traits\Collectors;

/**
 * Class OptionsCollectorTrait
 *
 * @package O2System\Spl\Traits\Collectors
 */
trait OptionsCollectorTrait
{
    /**
     * List of Options
     *
     * @type array
     */
    protected $options = [];

    // ------------------------------------------------------------------------

    /**
     * Add Option
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function addOption($key, $value)
    {
        if (isset($this->options[ $key ])) {
            if (is_array($value) AND is_array($this->options[ $key ])) {
                $this->options[ $key ] = array_merge($this->options[ $key ], $value);
            } else {
                $this->options[ $key ] = $value;
            }
        } else {
            $this->options[ $key ] = $value;
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Get Options
     *
     * @access  public
     * @final   this method can't be overwritten
     *
     * @param string|null $key Options item index name
     *
     * @return mixed
     */
    final public function getOption($key, $offset = null)
    {
        if (isset($this->options[ $key ])) {
            if (isset($offset)) {
                return isset($this->options[ $key ][ $offset ]) ? $this->options[ $key ][ $offset ] : null;
            }

            return $this->options[ $key ];
        }

        return false;
    }

    // ------------------------------------------------------------------------

    /**
     * Get Options
     *
     * @access  public
     * @final   this method can't be overwritten
     *
     * @param string|null $key Options item index name
     *
     * @return mixed
     */
    final public function getOptions(string $key = null, $offset = null)
    {
        if (isset($key)) {
            if (isset($this->options[ $key ])) {
                if (isset($offset)) {
                    return $this->options[$key][$offset] ?? null;
                }

                return $this->options[ $key ];
            }

            return false;
        }

        return $this->options;
    }

    // ------------------------------------------------------------------------

    /**
     * Set Options
     *
     * @access   public
     *
     * @param array|string|int|Options $key
     *
     * @return static
     */
    public function setOptions($key, $value = null)
    {
        if (is_array($key)) {
            if (empty($this->options)) {
                $this->options = $key;
            } else {
                $this->options = array_merge($this->options, $key);
            }
        } elseif ($key instanceof Options) {
            $this->options = $key;
        } elseif (isset($this->options[ $key ])) {
            if (is_array($value) AND is_array($this->options[ $key ])) {
                $this->options[ $key ] = array_merge($this->options[ $key ], $value);
            } else {
                $this->options[ $key ] = $value;
            }
        } else {
            $this->options[ $key ] = $value;
        }

        return $this;
    }
}