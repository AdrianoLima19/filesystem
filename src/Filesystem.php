<?php

declare(strict_types=1);

namespace Note\Filesystem;

use Note\Contracts\Filesystem\Filesystem as FilesystemContract;

/**
 * Class Filesystem
 * 
 * @license MIT
 * @package Note\Filesystem
 */
class Filesystem implements FilesystemContract
{
    /**
     * {@inheritDoc}
     */
    public function fileExists($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function dirExists($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function exists($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function read($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function readStream($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function write($path, $contents, $options = [])
    {
    }

    /**
     * {@inheritDoc}
     */
    public function writeStream($path, $contents, $options = [])
    {
    }

    /**
     * {@inheritDoc}
     */
    public function prepend($path, $contents)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function append($path, $contents)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getVisibility($path, $code = false)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function setVisibility($path, $visibility)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function deleteFile($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function deleteDirectory($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function makeDirectory($path, $options = [])
    {
    }

    /**
     * {@inheritDoc}
     */
    public function cleanDirectory($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function copyFile($from, $to, $options = [])
    {
    }

    /**
     * {@inheritDoc}
     */
    public function copyDirectory($from, $to, $options = [])
    {
    }

    /**
     * {@inheritDoc}
     */
    public function copy($from, $to, $options = [])
    {
    }

    /**
     * {@inheritDoc}
     */
    public function moveFile($from, $to, $options = [])
    {
    }

    /**
     * {@inheritDoc}
     */
    public function moveDirectory($from, $to, $options = [])
    {
    }

    /**
     * {@inheritDoc}
     */
    public function move($from, $to, $options = [])
    {
    }

    /**
     * {@inheritDoc}
     */
    public function isFile($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function isDir($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function fileSize($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function lastModified($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function mimeType($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function type($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function name($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function basename($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function dirname($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function extension($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function isReadable($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function isWritable($path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function listContents($path = null, $recursive = false)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function files($path = null, $recursive = false)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function directories($path = null, $recursive = false)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function allFiles($path = null)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function allDirectories($path = null)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function ensureDirectoryExists($dirname, $visibility)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function glob($pattern, $flags = 0)
    {
    }
}
