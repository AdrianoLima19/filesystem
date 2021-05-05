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
     * @return string|null
     */
    public function read($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return resource|null
     */
    public function readStream($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param string|resource $contents
     * @param array $options
     * @return boolean
     */
    public function write($path, $contents, $options = []);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param resource $contents
     * @param array $options
     * @return boolean
     */
    public function writeStream($path, $contents, $options = []);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param string $contents
     * @return boolean
     */
    public function prepend($path, $contents);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param string $contents
     * @return boolean
     */
    public function append($path, $contents);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param boolean $code
     * @return string|integer
     */
    public function getVisibility($path, $code = false);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param string|int $visibility
     * @return boolean
     */
    public function setVisibility($path, $visibility);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     */
    public function deleteFile($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     */
    public function deleteDirectory($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     */
    public function delete($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @param array $options
     * @return boolean
     */
    public function makeDirectory($path, $options = []);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     */
    public function cleanDirectory($path);

    /**
     * Undocumented function
     *
     * @param string $from
     * @param string $to
     * @param array $options
     * @return boolean
     */
    public function copyFile($from, $to, $options = []);

    /**
     * Undocumented function
     *
     * @param string $from
     * @param string $to
     * @param array $options
     * @return boolean
     */
    public function copyDirectory($from, $to, $options = []);

    /**
     * Undocumented function
     *
     * @param string $from
     * @param string $to
     * @param array $options
     * @return boolean
     */
    public function copy($from, $to, $options = []);

    /**
     * Undocumented function
     *
     * @param string $from
     * @param string $to
     * @param array $options
     * @return boolean
     */
    public function moveFile($from, $to, $options = []);

    /**
     * Undocumented function
     *
     * @param string $from
     * @param string $to
     * @param array $options
     * @return boolean
     */
    public function moveDirectory($from, $to, $options = []);

    /**
     * Undocumented function
     *
     * @param string $from
     * @param string $to
     * @param array $options
     * @return boolean
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
     * @return integer
     */
    public function fileSize($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return integer
     */
    public function lastModified($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string
     */
    public function mimeType($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string
     */
    public function type($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string
     */
    public function name($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string
     */
    public function basename($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string
     */
    public function dirname($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string
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
     * @internal //| decidir qual tipo de retorno.
     * 
     * @param string $path
     * @param boolean $recursive
     * @return mixed 
     */
    public function listContents($path = null, $recursive = false);

    /**
     * Undocumented function
     * @internal //| decidir qual tipo de retorno.
     * 
     * @param string $path
     * @param boolean $recursive
     * @return mixed 
     */
    public function files($path = null, $recursive = false);

    /**
     * Undocumented function
     * @internal //| decidir qual tipo de retorno.
     * 
     * @param string $path
     * @param boolean $recursive
     * @return mixed 
     */
    public function directories($path = null, $recursive = false);

    /**
     * Undocumented function
     * @internal //| decidir qual tipo de retorno.
     * 
     * @param string $path
     * @return mixed 
     */
    public function allFiles($path = null);

    /**
     * Undocumented function
     * @internal //| decidir qual tipo de retorno.
     * 
     * @param string $path
     * @return mixed 
     */
    public function allDirectories($path = null);

    /**
     * Undocumented function
     *
     * @param string $dirname
     * @param string|int $visibility
     * @return boolean
     */
    public function ensureDirectoryExists($dirname, $visibility);

    /**
     * Undocumented function
     *
     * @param string $pattern
     * @param integer $flags
     * @return array
     */
    public function glob($pattern, $flags = 0);
}
