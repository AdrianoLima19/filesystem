<?php

declare(strict_types=1);

namespace Note\Filesystem;

use Note\Contracts\Filesystem\Filesystem as FilesystemContract;
use Note\Contracts\Filesystem\FilesystemAdapter;

/**
 * Class Filesystem
 * 
 * @version 1.0.0-dev
 * @license MIT
 * @package Note\Filesystem
 */
class Filesystem extends FilesystemContract
{
    /**
     * Undocumented variable
     *
     * @var FilesystemAdapter
     */
    private $adapter;

    /**
     * Undocumented function
     *
     * @param FilesystemAdapter $adapter
     * @return void
     */
    public function __construct(
        FilesystemAdapter $adapter
    ) {
        $this->adapter = $adapter;
    }

    /**
     * {@inheritDoc}
     */
    public function fileExists($path)
    {
        return $this->adapter->fileExists($path);
    }

    /**
     * {@inheritDoc}
     */
    public function dirExists($path)
    {
        return $this->adapter->dirExists($path);
    }

    /**
     * {@inheritDoc}
     */
    public function exists($path)
    {
        return $this->adapter->exists($path);
    }

    /**
     * {@inheritDoc}
     */
    public function read($path)
    {
        return $this->adapter->read($path);
    }

    /**
     * {@inheritDoc}
     */
    public function readStream($path)
    {
        return $this->adapter->readStream($path);
    }

    /**
     * {@inheritDoc}
     */
    public function write($path, $contents, $options = [])
    {
        return $this->adapter->write($path, $contents, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function writeStream($path, $contents, $options = [])
    {
        $this->isResource($contents);
        $this->rewindStream($contents);

        return $this->adapter->writeStream($path, $contents, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function prepend($path, $contents)
    {
        return $this->adapter->prepend($path, $contents);
    }

    /**
     * {@inheritDoc}
     */
    public function append($path, $contents)
    {
        return $this->adapter->append($path, $contents);
    }

    /**
     * {@inheritDoc}
     */
    public function getVisibility($path, $code = false)
    {
        return $this->adapter->getVisibility($path, $code);
    }

    /**
     * {@inheritDoc}
     */
    public function setVisibility($path, $visibility)
    {
        return $this->adapter->setVisibility($path, $visibility);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteFile($path)
    {
        return $this->adapter->deleteFile($path);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteDirectory($path)
    {
        return $this->adapter->deleteDirectory($path);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path)
    {
        return $this->adapter->delete($path);
    }

    /**
     * {@inheritDoc}
     */
    public function makeDirectory($path, $options = [])
    {
        return $this->adapter->makeDirectory($path, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function cleanDirectory($path)
    {
        return $this->adapter->cleanDirectory($path);
    }

    /**
     * {@inheritDoc}
     */
    public function copyFile($from, $to, $options = [])
    {
        return $this->adapter->copyFile($from, $to, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function copyDirectory($from, $to, $options = [])
    {
        return $this->adapter->copyDirectory($from, $to, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function copy($from, $to, $options = [])
    {
        return $this->adapter->copy($from, $to, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function moveFile($from, $to, $options = [])
    {
        return $this->adapter->moveFile($from, $to, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function moveDirectory($from, $to, $options = [])
    {
        return $this->adapter->moveDirectory($from, $to, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function move($from, $to, $options = [])
    {
        return $this->adapter->move($from, $to, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function isFile($path)
    {
        return $this->adapter->isFile($path);
    }

    /**
     * {@inheritDoc}
     */
    public function isDir($path)
    {
        return $this->adapter->isDir($path);
    }

    /**
     * {@inheritDoc}
     */
    public function fileSize($path)
    {
        return $this->adapter->fileSize($path);
    }

    /**
     * {@inheritDoc}
     */
    public function lastModified($path)
    {
        return $this->adapter->lastModified($path);
    }

    /**
     * {@inheritDoc}
     */
    public function mimeType($path)
    {
        return $this->adapter->mimeType($path);
    }

    /**
     * {@inheritDoc}
     */
    public function type($path)
    {
        return $this->adapter->type($path);
    }

    /**
     * {@inheritDoc}
     */
    public function name($path)
    {
        return $this->adapter->name($path);
    }

    /**
     * {@inheritDoc}
     */
    public function basename($path)
    {
        return $this->adapter->basename($path);
    }

    /**
     * {@inheritDoc}
     */
    public function dirname($path)
    {
        return $this->adapter->dirname($path);
    }

    /**
     * {@inheritDoc}
     */
    public function extension($path)
    {
        return $this->adapter->extension($path);
    }

    /**
     * {@inheritDoc}
     */
    public function isReadable($path)
    {
        return $this->adapter->isReadable($path);
    }

    /**
     * {@inheritDoc}
     */
    public function isWritable($path)
    {
        return $this->adapter->isWritable($path);
    }

    /**
     * {@inheritDoc}
     */
    public function listContents($path = null, $recursive = false)
    {
        return $this->adapter->listContents($path, $recursive);
    }

    /**
     * {@inheritDoc}
     */
    public function listFiles($path = null, $recursive = false)
    {
        return $this->adapter->listFiles($path, $recursive);
    }

    /**
     * {@inheritDoc}
     */
    public function listDirectories($path = null, $recursive = false)
    {
        return $this->adapter->listDirectories($path, $recursive);
    }

    /**
     * {@inheritDoc}
     */
    public function listAllContents($path = null)
    {
        return $this->adapter->listAllContents($path);
    }

    /**
     * {@inheritDoc}
     */
    public function listAllFiles($path = null)
    {
        return $this->adapter->listAllFiles($path);
    }

    /**
     * {@inheritDoc}
     */
    public function listAllDirectories($path = null)
    {
        return $this->adapter->listAllDirectories($path);
    }

    /**
     * {@inheritDoc}
     */
    public function ensureDirectoryExists($dirname, $visibility)
    {
        return $this->adapter->ensureDirectoryExists($dirname, $visibility);
    }

    /**
     * {@inheritDoc}
     */
    public function glob($pattern, $flags = 0)
    {
        return $this->adapter->glob($pattern, $flags);
    }

    /**
     * @param mixed $contents
     */
    private function isResource($contents)
    {
        if (is_resource($contents) === false) {

            throw new \Note\Filesystem\Exception\InvalidStream("Invalid stream provided, expected stream resource, received " . gettype($contents));
        } elseif ($type = get_resource_type($contents) !== 'stream') {

            throw new \Note\Filesystem\Exception\InvalidStream("Invalid stream provided, expected stream resource, received resource of type " . $type);
        }
    }

    /**
     * @param resource $resource
     */
    private function rewindStream($resource)
    {
        if (ftell($resource) !== 0 && stream_get_meta_data($resource)['seekable']) {

            rewind($resource);
        }
    }
}
