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

namespace O2System\Spl\Info;

// ------------------------------------------------------------------------

/**
 * Class SplDirectoryInfo
 *
 * @package O2System\Spl\Info
 */
class SplDirectoryInfo
{
    /**
     * Directory Path Name
     *
     * @var string
     */
    private $pathName;

    /**
     * Directory Name
     *
     * @var string
     */
    private $dirName;

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::__construct
     *
     * @param string $dir Directory Path
     */
    public function __construct($dir)
    {
        $this->pathName = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, realpath($dir)) . DIRECTORY_SEPARATOR;
        $this->dirName = pathinfo($this->pathName, PATHINFO_FILENAME);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::isExists
     *
     * Determine if the directory is exists
     *
     * @return bool
     */
    public function isExists()
    {
        return (bool)is_dir($this->pathName);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getParentPath
     *
     * Gets the directory parent without trailing directory slash.
     *
     * @return string
     */
    public function getParentPath()
    {
        return dirname($this->pathName);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getParentRealPath
     *
     * Gets the directory real path
     *
     * @return string
     */
    public function getParentRealPath()
    {
        return dirname($this->pathName) . DIRECTORY_SEPARATOR;
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getParentRelativePath
     *
     * Gets the directory relative path
     *
     * @return string
     */
    public function getParentRelativePath()
    {
        $scriptFilename = str_replace(['/', '\\'], '/', dirname($_SERVER[ 'SCRIPT_FILENAME' ]));
        $relativePath = str_replace(['/', '\\'], '/', dirname($this->pathName)) . '/';

        if (strpos($scriptFilename, 'public')) {
            return str_replace(dirname($scriptFilename), '..', $relativePath);
        }

        return str_replace($scriptFilename, '', $relativePath);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getPathInfo
     *
     * Gets an SplDirectoryInfo object for the parent of the current file.
     *
     * @param string|null $className Name of an SplDirectoryInfo derived class to use.
     *
     * @return \O2System\Spl\Info\SplDirectoryInfo
     */
    public function getPathInfo($className = null)
    {
        return isset($className) ? new $className(pathinfo($this->pathName)) : $this;
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getDirName
     *
     * Gets the directory name without any path information.
     *
     * @return string
     */
    public function getDirName()
    {
        return $this->dirName;
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getPathName
     *
     * Gets the path to the directory without trailing directory slash.
     *
     * @return null|string
     */
    public function getPathName()
    {
        return isset($this->pathName) ? $this->getPath() : null;
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getPath
     *
     * Gets the path to the directory without trailing directory slash.
     *
     * @return string
     */
    public function getPath()
    {
        return realpath($this->pathName);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getRealPath
     *
     * Gets the path to the directory
     *
     * @return string
     */
    public function getRealPath()
    {
        return $this->pathName;
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getRelativePath
     *
     * Gets the realtive path to the directory, for html link purposes.
     *
     * @return string
     */
    public function getRelativePath()
    {
        $scriptFilename = str_replace(['/', '\\'], '/', dirname($_SERVER[ 'SCRIPT_FILENAME' ]));
        $relativePath = str_replace(['/', '\\'], '/', $this->pathName);

        if (strpos($scriptFilename, 'public')) {
            return str_replace(dirname($scriptFilename), '..', $relativePath);
        }

        return str_replace($scriptFilename, '', $relativePath);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::isReadable
     *
     * Determine if the directory is readable
     *
     * @return bool
     */
    public function isReadable()
    {
        return (bool)is_dir($this->pathName);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::isWritable
     *
     * Determine if the directory is writable
     *
     * @return bool
     */
    public function isWritable()
    {
        // If we're on a Unix server with safe_mode off we call is_writable
        if (DIRECTORY_SEPARATOR === '/' AND
            (strpos(phpversion(), '5.4') !== false OR ! ini_get('safe_mode'))
        ) {
            return (bool)is_writable($this->pathName);
        }

        /* For Windows servers and safe_mode "on" installations we'll actually
         * write a file then read it. Bah...
         */
        if (is_dir($this->pathName)) {
            $file = $this->pathName . md5(mt_rand());
            if (($fp = @fopen($file, 'ab')) === false) {
                return false;
            }

            fclose($fp);
            @chmod($file, 0777);
            @unlink($file);

            return true;
        } elseif ( ! is_dir($this->pathName) OR ($fp = @fopen($this->pathName, 'ab')) === false) {
            return false;
        }

        fclose($fp);

        return true;
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getATime
     *
     * Gets last access time of the directory.
     *
     * @return int
     */
    public function getATime()
    {
        return fileatime($this->pathName);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getCTime
     *
     * Gets the inode change time of the directory.
     *
     * @return int
     */
    public function getCTime()
    {
        return filectime($this->pathName);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getMTime
     *
     * Gets the last modified time of the directory.
     *
     * @return int
     */
    public function getMTime()
    {
        return filemtime($this->pathName);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getInode
     *
     * Gets the inode number for the filesystem directory object.
     *
     * @return int
     */
    public function getInode()
    {
        return fileinode($this->pathName);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getPerms
     *
     * Gets the permissions for the directory
     *
     * @param bool $octal
     *
     * @return int
     */
    public function getPerms($octal = false)
    {
        return $octal === false ? fileperms($this->pathName) : 0 . decoct(fileperms($this->pathName) & 0777);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getOwner
     *
     * Gets the directory owner. The owner ID is can be returned in numerical format or string of owner id.
     *
     * @param bool $id
     *
     * @return array|int|string
     */
    public function getOwner($id = false)
    {
        if ($id) {
            if (false !== ($uid = fileowner($this->pathName))) {
                if (function_exists('posix_getpwuid')) {
                    return posix_getpwuid($uid);
                } elseif ($uid == 0) {
                    return 'root';
                }
            }
        }

        return fileowner($this->pathName);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getGroup
     *
     * Gets the directory group. The group ID is can be returned in numerical format or string of group id.
     *
     * @param bool $id
     *
     * @return array|int|string
     */
    public function getGroup($id = false)
    {
        if ($id) {
            if (false !== ($grid = fileowner($this->pathName))) {
                if (function_exists('posix_getgrgid')) {
                    return posix_getgrgid($grid);
                } elseif ($grid == 0) {
                    return 'root';
                }
            }
        }

        return filegroup($this->pathName);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getStat
     *
     * Gets the directory information.
     *
     * @return array
     */
    public function getStat()
    {
        return stat($this->pathName);
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getSize
     *
     * Gets the directory total size
     *
     * @return int
     */
    public function getSize()
    {
        $size = 0;

        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->pathName));

        foreach ($files as $file) {
            $size += $file->getSize();
        }

        return $size;
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getTree
     *
     * Gets the directory files and directories tree.
     *
     * @return array
     */
    public function getTree()
    {
        $tree = [];
        $directoryIterator = new \DirectoryIterator($this->pathName);

        foreach ($directoryIterator as $directoryNode) {
            if ($directoryNode->isDir() AND $directoryNode->isDot() === false) {
                $tree[ $directoryNode->getFilename() ] = (new SplDirectoryInfo(
                    $directoryNode->getPathName()
                ))->getTree();
            } elseif ($directoryNode->isFile()) {
                $tree[] = $directoryNode->getFilename();
            }
        }

        arsort($tree, SORT_FLAG_CASE);

        return $tree;
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::getHandle
     *
     * Returns the directory resource handle.
     *
     * @return resource
     */
    public function getHandle()
    {
        return dir($this->pathName)->handle;
    }

    // ------------------------------------------------------------------------

    /**
     * SplDirectoryInfo::__toString
     *
     * This method will return the directory path name.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->pathName;
    }
}