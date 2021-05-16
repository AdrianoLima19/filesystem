<?php

declare(strict_types=1);

namespace Note\Contracts\Filesystem;

/**
 * Interface Filesystem
 * 
 * @license MIT
 * @package Note\Contracts\Filesystem
 */
interface Filesystem
{
    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     */
    public function fileExists($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     */
    public function dirExists($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     */
    public function exists($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string|false
     * 
     * @throws \Note\Filesystem\Exception\UnableToReadFile
     */
    public function read($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return resource|false
     * 
     * @throws \Note\Filesystem\Exception\UnableToReadFile
     */
    public function readStream($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param string|resource $contents
     * @param array $options
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToWriteFile
     */
    public function write($path, $contents, $options = []);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param resource $contents
     * @param array $options
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToWriteFile
     */
    public function writeStream($path, $contents, $options = []);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param string $contents
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToWriteFile
     */
    public function prepend($path, $contents);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param string $contents
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToWriteFile
     */
    public function append($path, $contents);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param boolean $code
     * @return string|integer|false
     * 
     * @throws \Note\Filesystem\Exception\UnableToRetrieveMetadata
     */
    public function getVisibility($path, $code = false);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param string|integer $visibility
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToSetMetadata
     */
    public function setVisibility($path, $visibility);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToDeleteFile
     */
    public function deleteFile($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToDeleteFile
     * @throws \Note\Filesystem\Exception\UnableToDeleteDirectory
     */
    public function deleteDirectory($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToDeleteFile
     * @throws \Note\Filesystem\Exception\UnableToDeleteDirectory
     */
    public function delete($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param array $options
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToCreateDirectory
     */
    public function makeDirectory($path, $options = []);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToDeleteFile
     * @throws \Note\Filesystem\Exception\UnableToDeleteDirectory
     */
    public function cleanDirectory($path);

    /**
     * Undocumented function
     *
     * @param string $from
     * @param string $to
     * @param array $options
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToCopyFile
     */
    public function copyFile($from, $to, $options = []);

    /**
     * Undocumented function
     *
     * @param string $from
     * @param string $to
     * @param array $options
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToCopyFile
     * @throws \Note\Filesystem\Exception\UnableToCopyDirectory
     */
    public function copyDirectory($from, $to, $options = []);

    /**
     * Undocumented function
     *
     * @param string $from
     * @param string $to
     * @param array $options
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToCopyFile
     * @throws \Note\Filesystem\Exception\UnableToCopyDirectory
     */
    public function copy($from, $to, $options = []);

    /**
     * Undocumented function
     *
     * @param string $from
     * @param string $to
     * @param array $options
     * @return boolean
     * 
     * @throws UnableToMoveFile
     */
    public function moveFile($from, $to, $options = []);

    /**
     * Undocumented function
     *
     * @param string $from
     * @param string $to
     * @param array $options
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToMoveFile
     * @throws \Note\Filesystem\Exception\UnableToMoveDirectory
     */
    public function moveDirectory($from, $to, $options = []);

    /**
     * Undocumented function
     *
     * @param string $from
     * @param string $to
     * @param array $options
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToMoveFile
     * @throws \Note\Filesystem\Exception\UnableToMoveDirectory
     */
    public function move($from, $to, $options = []);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     */
    public function isFile($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     */
    public function isDir($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return integer|false
     * 
     * @throws \Note\Filesystem\Exception\UnableToRetrieveMetadata
     */
    public function fileSize($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return integer|false
     * 
     * @throws \Note\Filesystem\Exception\UnableToRetrieveMetadata
     */
    public function lastModified($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string|false
     * 
     * @throws \Note\Filesystem\Exception\UnableToRetrieveMetadata
     */
    public function mimeType($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string|false
     * 
     * @throws \Note\Filesystem\Exception\UnableToRetrieveMetadata
     */
    public function type($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string|false
     * 
     * @throws \Note\Filesystem\Exception\UnableToRetrieveMetadata
     */
    public function name($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string|false
     * 
     * @throws \Note\Filesystem\Exception\UnableToRetrieveMetadata
     */
    public function basename($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string|false
     * 
     * @throws \Note\Filesystem\Exception\UnableToRetrieveMetadata
     */
    public function dirname($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string|false
     * 
     * @throws \Note\Filesystem\Exception\UnableToRetrieveMetadata
     */
    public function extension($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     */
    public function isReadable($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     */
    public function isWritable($path);

    /**
     * Undocumented function
     * 
     * @param string|null $path
     * @param boolean $recursive
     * @return iterable
     */
    public function listContents($path = null, $recursive = false);

    /**
     * Undocumented function
     * 
     * @param string|null $path
     * @param boolean $recursive
     * @return iterable
     */
    public function listFiles($path = null, $recursive = false);

    /**
     * Undocumented function
     * 
     * @param string|null $path
     * @param boolean $recursive
     * @return iterable
     */
    public function listDirectories($path = null, $recursive = false);

    /**
     * Undocumented function
     * 
     * @param string|null $path
     * @return iterable
     */
    public function listAllContents($path = null);

    /**
     * Undocumented function
     * 
     * @param string|null $path
     * @return iterable
     */
    public function listAllFiles($path = null);

    /**
     * Undocumented function
     * 
     * @param string|null $path
     * @return iterable
     */
    public function listAllDirectories($path = null);

    /**
     * Undocumented function
     *
     * @param string $dirname
     * @param int $visibility
     * @return boolean
     * 
     * @throws \Note\Filesystem\Exception\UnableToCreateDirectory
     */
    public function ensureDirectoryExists($dirname, $visibility);

    /**
     * Undocumented function
     *
     * @param string $pattern
     * @param integer $flags
     * @return array|false
     * 
     * @throws \Note\Filesystem\Exception\UnableToReadFile
     */
    public function glob($pattern, $flags = 0);
}
