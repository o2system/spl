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

namespace O2System\Spl\Traits;

// ------------------------------------------------------------------------

/**
 * Class OptionsSetterTrait
 *
 * @package O2System\Spl\Traits\Collectors
 */
trait OptionsSetterTrait
{
    /**
     * OptionsSetterTrait::setOptions
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options)
    {
        if (count($options)) {
            foreach ($options as $method => $value) {
                $method = camelcase('set_' . $method);

                if (method_exists($this, $method)) {
                    call_user_func_array([&$this, $method], [$value]);
                }
            }
        }

        return $this;
    }
}