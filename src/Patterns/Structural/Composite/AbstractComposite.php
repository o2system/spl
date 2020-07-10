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

use O2System\Spl\Traits\Collectors\OptionsCollectorTrait;

/**
 * Class AbstractBuilder
 * @package O2System\Spl\Patterns\Builder
 */
abstract class AbstractComposite implements RenderableInterface
{
    use OptionsCollectorTrait;

    // ------------------------------------------------------------------------

    /**
     * AbstractComposite::__toString
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->render($this->options);
    }
}