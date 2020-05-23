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

/**
 * Class FileExtensionCollectorTrait
 *
 * @package O2System\Spl\Traits\Collectors
 */
trait FileExtensionCollectorTrait
{
    protected $fileExtensions = [];

    public function getFileExtensions()
    {
        return $this->fileExtensions;
    }

    public function setFileExtensions(array $fileExtensions)
    {
        $this->fileExtensions = $fileExtensions;

        return $this;
    }

    public function addFileExtensions(array $fileExtensions)
    {
        foreach ($fileExtensions as $fileExtension) {
            $this->addFileExtension($fileExtension);
        }

        return $this;
    }

    public function addFileExtension($fileExtension)
    {
        $fileExtension = '.' . trim($fileExtension, '.');

        if ( ! in_array($fileExtension, $this->fileExtensions)) {
            array_push($this->fileExtensions, $fileExtension);
        }

        return $this;
    }
}