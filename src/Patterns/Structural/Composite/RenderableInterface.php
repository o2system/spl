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

namespace O2System\Spl\Patterns\Structural\Composite;

/**
 * Interface RenderableInterface
 * @package O2System\Spl\Patterns\Structural\Composite
 */
interface RenderableInterface
{
    /**
     * RenderableInterface::render
     *
     * @param array $options
     *
     * @return mixed
     */
    public function render(array $options = []);
}