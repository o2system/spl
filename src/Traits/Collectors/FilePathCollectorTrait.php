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
 * Class PathCollectorTrait
 *
 * @package O2System\Spl\Traits\Collectors
 */
trait FilePathCollectorTrait
{
    /**
     * Sub Path
     *
     * @type string|null
     */
    protected $fileDirName = null;

    // ------------------------------------------------------------------------

    /**
     * List of Paths
     *
     * @type array
     */
    protected $filePaths = [];

    public function setFileDirName($fileDirName)
    {
        $this->fileDirName = $fileDirName;

        return $this;
    }

    // ------------------------------------------------------------------------

    public function removeFilePath($filePath)
    {
        if (false !== ($key = array_search($filePath, $this->filePaths))) {
            unset($this->filePaths[ $key ]);
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    public function getFilePaths($reverse = false)
    {
        return ($reverse === true ? array_reverse($this->filePaths) : $this->filePaths);
    }

    // ------------------------------------------------------------------------

    public function setFilePaths(array $filePaths)
    {
        $this->filePaths = [];
        $this->addFilePaths($filePaths);

        return $this;
    }

    // ------------------------------------------------------------------------

    public function addFilePaths(array $filePaths)
    {
        foreach ($filePaths as $filePath) {
            $this->addFilePath($filePath);
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    public function addFilePath($filePath, $offset = null)
    {
        $filePath = rtrim(
                str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $filePath),
                DIRECTORY_SEPARATOR
            ) . DIRECTORY_SEPARATOR;

        if (isset($this->fileDirName)) {
            $filePath = str_replace(
                    $this->fileDirName . DIRECTORY_SEPARATOR,
                    '',
                    $filePath
                ) . $this->fileDirName . DIRECTORY_SEPARATOR;
        }

        return $this->pushFilePath($filePath, $offset);
    }

    // ------------------------------------------------------------------------
    
    public function pushFilePath($filePath, $offset = null)
    {
        if (is_dir($filePath) AND ! in_array($filePath, $this->filePaths)) {
            if (isset($offset)) {
                $this->filePaths[ $offset ] = $filePath;
            } else {
                $this->filePaths[] = $filePath;
            }
        }

        return $this;
    }
}