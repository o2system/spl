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
    /**
     * FileExtensionCollectorTrait::$fileExtensions
     *
     * @var array
     */
    protected $fileExtensions = [];

    // ------------------------------------------------------------------------

    /**
     * FileExtensionCollectorTrait::getFileExtensions
     *
     * @return array
     */
    public function getFileExtensions()
    {
        return $this->fileExtensions;
    }

    // ------------------------------------------------------------------------

    /**
     * FileExtensionCollectorTrait::setFileExtensions
     *
     * @param array $fileExtensions
     * 
     * @return static
     */
    public function setFileExtensions(array $fileExtensions)
    {
        $this->fileExtensions = $fileExtensions;

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * FileExtensionCollectorTrait::addFileExtension
     *
     * @param array $fileExtensions
     * 
     * @return static
     */
    public function addFileExtensions(array $fileExtensions)
    {
        foreach ($fileExtensions as $fileExtension) {
            $this->addFileExtension($fileExtension);
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * FileExtensionCollectorTrait::addFileExtension
     *
     * @param string $fileExtension
     * 
     * @return static
     */
    public function addFileExtension($fileExtension)
    {
        $fileExtension = '.' . trim($fileExtension, '.');

        if ( ! in_array($fileExtension, $this->fileExtensions)) {
            array_push($this->fileExtensions, $fileExtension);
        }

        return $this;
    }
}