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

namespace O2System\Spl\Patterns\Structural\Repository;

/**
 * Interface StorageInterface
 * @package O2System\Spl\Patterns\Structural\Repository
 */
interface StorageInterface
{
    public function store($offset, $data);

    /**
     * StorageInterface::search
     *
     * Search data based on array offset key.
     *
     * @param string $offset The data offset key.
     * @param mixed  $return The fail over of data returns when the data is not found.
     *
     * @return mixed The returns is varies depends on the content of the data or the return variable.
     */
    public function search($offset, $return = false);
}