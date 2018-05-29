<?php
/**
 * This file is part of the O2System PHP Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author         Steeve Andrian Salim
 * @copyright      Copyright (c) Steeve Andrian Salim
 */

// ------------------------------------------------------------------------

namespace O2System\Spl\Info;

// ------------------------------------------------------------------------

/**
 * Class SplFileInfo
 *
 * @package O2System\Spl\Info
 */
class SplFileInfo extends \SplFileInfo
{
    /**
     * SplFileInfo::$mime
     *
     * File mime type.
     *
     * @var
     */
    private $mime;

    /**
     * SplFileInfo::__construct
     *
     * @param string $filePath File Path.
     */
    public function __construct($filePath)
    {
        parent::__construct($filePath);

        if (file_exists($filePath)) {
            $this->mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filePath);
        }
    }

    public function getMime()
    {
        return $this->mime;
    }

    /**
     * SplFileInfo::getFilename
     *
     * @return string
     */
    public function getFilename()
    {
        return str_replace('.' . $this->getExtension(), '', parent::getFilename());
    }

    /**
     * SplFileInfo::getBasename
     *
     * @param string $suffix
     *
     * @return string
     */
    public function getBasename($suffix = null)
    {
        if (is_null($suffix)) {
            return parent::getBasename();
        }

        return str_replace('.' . $this->getExtension(), '.' . trim($suffix, '.'), parent::getFilename());
    }

    /**
     * SplFileInfo::getDirectoryInfo
     *
     * @return \O2System\Spl\Info\SplDirectoryInfo
     */
    public function getDirectoryInfo()
    {
        return new SplDirectoryInfo(dirname($this->getRealPath()));
    }
}