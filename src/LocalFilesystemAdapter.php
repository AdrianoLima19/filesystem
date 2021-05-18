<?php

declare(strict_types=1);

namespace Note\Filesystem;

use Note\Contracts\Filesystem\FilesystemAdapter as Adapter;
use Note\Filesystem\Exception\UnableToReadFile;
use Note\Filesystem\Exception\UnableToWriteFile;
use Note\Filesystem\Exception\UnableToRetrieveMetadata;
use Note\Filesystem\Exception\UnableToSetMetadata;
use Note\Filesystem\Exception\UnableToCreateDirectory;
use Note\Filesystem\Exception\UnableToDeleteDirectory;
use Note\Filesystem\Exception\UnableToDeleteFile;
use Note\Filesystem\Exception\UnableToCopyFile;
use Note\Filesystem\Exception\UnableToCopyDirectory;
use Note\Filesystem\Exception\UnableToMoveFile;
use Note\Filesystem\Exception\UnableToMoveDirectory;

/**
 * Class LocalFilesystemAdapter
 * 
 * @license MIT
 * @package Note\Filesystem
 */
class LocalFilesystemAdapter implements Adapter
{
    /**
     * Undocumented variable
     *
     * @var \Note\Contracts\Filesystem\FilesystemProvider
     */
    private $provider;

    /**
     * Undocumented variable
     *
     * @var integer
     */
    private $writeFlags;

    /**
     * Undocumented variable
     *
     * @var boolean
     */
    private $errorHandler;

    /**
     * Undocumented variable
     *
     * @var boolean
     */
    private $ensureDirectory;

    /**
     * Undocumented function
     *
     * @param string $location
     * @param array $visibility
     * @param integer writeFlags
     * @param boolean errorHandler
     * @param boolean ensureDirectory
     * @return void
     */
    public function __construct(
        $location,
        $visibility = [],
        $writeFlags = LOCK_EX,
        $errorHandler = true,
        $ensureDirectory = true,
    ) {
        $this->provider =  new \Note\Filesystem\FilesystemProvider($location, DIRECTORY_SEPARATOR);

        if (!empty($visibility)) {

            $this->provider->setPermissions($visibility);
        }

        $this->writeFlags = $writeFlags;

        $this->errorHandler = $errorHandler;

        $this->ensureDirectory = $ensureDirectory;
    }

    /**
     * {@inheritDoc}
     */
    public function fileExists($path)
    {
        $location = $this->provider->addPath($path);

        return is_file($location);
    }

    /**
     * {@inheritDoc}
     */
    public function dirExists($path)
    {
        $location = $this->provider->addPath($path);

        return is_dir($location);
    }

    /**
     * {@inheritDoc}
     */
    public function exists($path)
    {
        $location = $this->provider->addPath($path);

        return file_exists($location);
    }

    /**
     * {@inheritDoc}
     */
    public function read($path)
    {
        $contents = @file_get_contents($this->provider->addPath($path));

        if ($contents === false) {

            if (!$this->errorHandler) {

                return false;
            }

            throw new UnableToReadFile("Unable to read file at path {$path}");
        }

        return $contents;
    }

    /**
     * {@inheritDoc}
     */
    public function readStream($path)
    {
        $contents = @fopen($this->provider->addPath($path), "rb");

        if ($contents === false) {

            if (!$this->errorHandler) {

                return false;
            }

            throw new UnableToReadFile("Unable to read stream at path {$path}");
        }

        return $contents;
    }

    /**
     * {@inheritDoc}
     */
    public function write($path, $contents, $options = [])
    {
        $location = $this->provider->addPath($path);

        $ensureDirectory = $options['ensureDirectory'] ?? $this->ensureDirectory;

        if ($ensureDirectory) {

            $visibility = $options['visibility'] ?? null;

            $this->ensureDirectoryExists(
                dirname($location),
                gettype($visibility) === 'integer'
                    ? $visibility
                    : $this->directoryVisibility($visibility)
            );
        }

        if (@file_put_contents($location, $contents, $this->writeFlags) === false) {

            if (!$this->errorHandler) {

                return false;
            }

            throw new UnableToWriteFile("Unable to write file at path {$path}");
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function writeStream($path, $contents, $options = [])
    {
        $location = $this->provider->addPath($path);

        $ensureDirectory = $options['ensureDirectory'] ?? $this->ensureDirectory;

        if ($ensureDirectory) {

            $visibility = $options['visibility'] ?? null;

            $this->ensureDirectoryExists(
                dirname($location),
                gettype($visibility) === 'integer'
                    ? $visibility
                    : $this->directoryVisibility($visibility)
            );
        }

        $stream = @fopen($location, 'w+b');

        if (!($stream && false !== stream_copy_to_stream($contents, $stream) && fclose($stream))) {

            if (!$this->errorHandler) {

                return false;
            }

            throw new UnableToWriteFile("Unable to write stream at path {$path}");
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function prepend($path, $contents)
    {
        if ($this->exists($path)) {

            return $this->write($path, $contents . $this->read($path));
        }

        return $this->write($path, $contents);
    }

    /**
     * {@inheritDoc}
     */
    public function append($path, $contents)
    {
        if ($this->exists($path)) {

            return $this->write($path, $this->read($path) . $contents);
        }

        return $this->write($path, $contents);
    }

    /**
     * {@inheritDoc}
     */
    public function getVisibility($path, $code = false)
    {
        $location = $this->provider->addPath($path);

        $visibility = @fileperms($location);

        if ($visibility === false) {

            if (!$this->errorHandler) {

                return false;
            }

            throw new UnableToRetrieveMetadata("Unable to get visibility at path {$path}");
        }

        return $code ? $visibility & 0777 : $visibility = $this->provider->invisibilityForFile($visibility);
    }

    /**
     * {@inheritDoc}
     */
    public function setVisibility($path, $visibility)
    {
        $location = $this->provider->addPath($path);

        if (gettype($visibility) === 'string') {

            $visibility = is_dir($location)
                ? $this->provider->invisibilityForDirectory($visibility)
                : $this->provider->invisibilityForFile($visibility);
        }

        if (!@chmod($location, $visibility)) {

            if (!$this->errorHandler) {

                return false;
            }

            throw new UnableToSetMetadata("Unable to set visibility at path {$location}");
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteFile($path)
    {
        $location = $this->provider->addPath($path);

        if (!$this->exists($path)) {

            return true;
        }

        if (!@unlink($location)) {

            if (!$this->errorHandler) {

                return false;
            }

            throw new UnableToDeleteFile("Unable to set visibility at path {$location}");
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteDirectory($path)
    {
        $location = $this->provider->addPath($path);

        if (!is_dir($location)) {

            return true;
        }

        $contents = $this->listDirectoryRecursively($location, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($contents as $file) {

            if (!$this->autoDelete($file)) {

                if (!$this->errorHandler) {

                    return false;
                }

                if ($file->isFile()) {

                    throw new UnableToDeleteFile("Unable to delete file at path {$location}");
                }

                throw new UnableToDeleteDirectory("Unable to delete directory at path {$location}");
            }
        }

        if (!@rmdir($location)) {

            if (!$this->errorHandler) {

                return false;
            }

            throw new UnableToDeleteDirectory("Unable to delete directory at path {$location}");
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path)
    {
        if ($this->fileExists($path)) {

            return $this->deleteFile($path);
        }

        return $this->deleteDirectory($path);
    }

    /**
     * {@inheritDoc}
     */
    public function makeDirectory($path, $options = [])
    {
        $location = $this->provider->addPath($path);

        $visibility = $this->directoryVisibility($options['visibility'] ?? null);
        $permissions = (gettype($visibility) == 'string') ? $this->directoryVisibility($visibility) : $visibility;

        if (is_dir($location)) {

            $this->setVisibility($path, $permissions);

            return true;
        }

        if (!@mkdir($location, $permissions, true)) {

            if (!$this->errorHandler) {

                return false;
            }

            throw new UnableToCreateDirectory("Unable to create directory at path {$path}");
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function cleanDirectory($path)
    {
        $location = $this->provider->addPath($path);

        if (!is_dir($location)) {

            return true;
        }

        $contents = $this->listDirectoryRecursively($location, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($contents as $file) {

            if (!$this->autoDelete($file)) {

                if (!$this->errorHandler) {

                    return false;
                }

                if ($file->isFile()) {

                    throw new UnableToDeleteFile("Unable to delete file at path {$location}");
                }

                throw new UnableToDeleteDirectory("Unable to delete directory at path {$location}");
            }
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function copyFile($from, $to, $options = [])
    {
        $source = $this->provider->addPath($from);
        $destination = $this->provider->addPath($to);

        $ensureDirectory = $options['ensureDirectory'] ?? $this->ensureDirectory;

        if ($ensureDirectory) {

            $this->ensureDirectoryExists(dirname($destination), $this->directoryVisibility($options['visibility'] ?? null));
        }

        if (!@copy($source, $destination)) {

            if (!$this->errorHandler) {

                return false;
            }

            throw new UnableToCopyFile("Unable to copy file from path {$from} to {$to}");
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function copyDirectory($from, $to, $options = [])
    {
        $source = $this->provider->addPath($from);
        $destination = $this->provider->addPath($to);

        $ensureDirectory = $options['ensureDirectory'] ?? $this->ensureDirectory;

        if ($ensureDirectory) {

            $this->ensureDirectoryExists(dirname($destination), $this->directoryVisibility($options['visibility'] ?? null));
        }

        $list = $this->listDirectoryRecursively($source);

        foreach ($list as $file) {

            if ($file->isDir()) {

                if (
                    !$this->ensureDirectoryExists(
                        $destination . substr(
                            $file->getPathName(),
                            strlen($source)
                        ),
                        $this->directoryVisibility($options['visibility'] ?? null)
                    )
                ) {

                    if (!$this->errorHandler) {

                        return false;
                    }

                    throw new UnableToCopyDirectory("Unable to copy file from path {$from} to {$to}");
                }

                continue;
            }

            $this->copyFile(
                $this->provider->removePath($source) . substr($file->getPathName(), strlen($source)),
                $this->provider->removePath($destination) . substr($file->getPathName(), strlen($source))
            );
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function copy($from, $to, $options = [])
    {
        if ($this->fileExists($from)) {

            return $this->copyFile($from, $to, $options);
        }

        return $this->copyDirectory($from, $to, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function moveFile($from, $to, $options = [])
    {
        return $this->move($from, $to, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function moveDirectory($from, $to, $options = [])
    {
        return $this->move($from, $to, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function move($from, $to, $options = [])
    {
        $source = $this->provider->addPath($from);
        $destination = $this->provider->addPath($to);

        $ensureDirectory = $options['ensureDirectory'] ?? $this->ensureDirectory;

        if ($ensureDirectory) {

            $this->ensureDirectoryExists(dirname($destination), $this->directoryVisibility($options['visibility'] ?? null));
        }

        if (!@rename($source, $destination)) {

            if (!$this->errorHandler) {

                return false;
            }

            if (is_dir($source)) {

                throw new UnableToMoveDirectory("Unable to move directory from path {$from} to {$to}");
            }

            throw new UnableToMoveFile("Unable to move file from path {$from} to {$to}");
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isFile($path)
    {
        $location = $this->provider->addPath($path);

        return is_file($location);
    }

    /**
     * {@inheritDoc}
     */
    public function isDir($path)
    {
        $location = $this->provider->addPath($path);

        return is_dir($location);
    }

    /**
     * {@inheritDoc}
     */
    public function fileSize($path)
    {
        $location = $this->provider->addPath($path);

        if ($this->isFile($path) && ($fileSize = @filesize($location)) !== false) {

            return $fileSize;
        }

        if (!$this->errorHandler) {

            return false;
        }

        throw new UnableToRetrieveMetadata("Unable to get file size at path {$path}");
    }

    /**
     * {@inheritDoc}
     */
    public function lastModified($path)
    {
        $location = $this->provider->addPath($path);

        if (($lastModified = @filemtime($location)) !== false) {

            return $lastModified;
        }

        if (!$this->errorHandler) {

            return false;
        }

        throw new UnableToRetrieveMetadata("Unable to get file modification time at path {$path}");
    }

    /**
     * {@inheritDoc}
     */
    public function mimeType($path)
    {
        $location = $this->provider->addPath($path);

        if ($mimeType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $location) !== false) {

            return $mimeType;
        }

        if (!$this->errorHandler) {

            return false;
        }

        throw new UnableToRetrieveMetadata("Unable to get mime type at path {$path}");
    }

    /**
     * {@inheritDoc}
     */
    public function type($path)
    {
        $location = $this->provider->addPath($path);

        if ($type = filetype($location) !== false) {

            return $type;
        }

        if (!$this->errorHandler) {

            return false;
        }

        throw new UnableToRetrieveMetadata("Unable to get type at path {$path}");
    }

    /**
     * {@inheritDoc}
     */
    public function name($path)
    {
        $location = $this->provider->addPath($path);

        if ($type = pathinfo($location, PATHINFO_FILENAME) !== false) {

            return $type;
        }

        if (!$this->errorHandler) {

            return false;
        }

        throw new UnableToRetrieveMetadata("Unable to get file name at path {$path}");
    }

    /**
     * {@inheritDoc}
     */
    public function basename($path)
    {
        $location = $this->provider->addPath($path);

        if ($type = pathinfo($location, PATHINFO_BASENAME) !== false) {

            return $type;
        }

        if (!$this->errorHandler) {

            return false;
        }

        throw new UnableToRetrieveMetadata("Unable to get file basename at path {$path}");
    }

    /**
     * {@inheritDoc}
     */
    public function dirname($path)
    {
        $location = $this->provider->addPath($path);

        if ($type = pathinfo($location, PATHINFO_DIRNAME) !== false) {

            return $type;
        }

        if (!$this->errorHandler) {

            return false;
        }

        throw new UnableToRetrieveMetadata("Unable to get file dirname at path {$path}");
    }

    /**
     * {@inheritDoc}
     */
    public function extension($path)
    {
        $location = $this->provider->addPath($path);

        if ($type = pathinfo($location, PATHINFO_EXTENSION) !== false) {

            return $type;
        }

        if (!$this->errorHandler) {

            return false;
        }

        throw new UnableToRetrieveMetadata("Unable to get file extension at path {$path}");
    }

    /**
     * {@inheritDoc}
     */
    public function isReadable($path)
    {
        $location = $this->provider->addPath($path);

        return is_readable($location);
    }

    /**
     * {@inheritDoc}
     */
    public function isWritable($path)
    {
        $location = $this->provider->addPath($path);

        return is_writable($location);
    }

    /**
     * {@inheritDoc}
     */
    public function listContents($path = null, $recursive = false)
    {
        if ($recursive) {

            return $this->listAllContents($path);
        }

        $location = $this->provider->addPath($path);

        return $this->listDirectory($location);
    }

    /**
     * {@inheritDoc}
     */
    public function listFiles($path = null, $recursive = false)
    {
        if ($recursive) {

            return $this->listAllFiles($path);
        }

        $location = $this->provider->addPath($path);

        $filter = $this->listDirectory($location);

        foreach ($filter as $files) {

            if ($files->isDir()) {

                continue;
            }

            yield $files;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function listDirectories($path = null, $recursive = false)
    {
        if ($recursive) {

            return $this->listAllDirectories($path);
        }

        $location = $this->provider->addPath($path);

        $filter = $this->listDirectory($location);

        foreach ($filter as $files) {

            if ($files->isFile()) {

                continue;
            }

            yield $files;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function listAllContents($path = null)
    {
        $location = $this->provider->addPath($path);

        return $this->listDirectoryRecursively($location);
    }

    /**
     * {@inheritDoc}
     */
    public function listAllFiles($path = null)
    {
        $location = $this->provider->addPath($path);

        $filter = $this->listDirectoryRecursively($location);

        foreach ($filter as $files) {

            if ($files->isDir()) {

                continue;
            }

            yield $files;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function listAllDirectories($path = null)
    {
        $location = $this->provider->addPath($path);

        $filter = $this->listDirectoryRecursively($location);

        foreach ($filter as $files) {

            if ($files->isFile()) {

                continue;
            }

            yield $files;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function ensureDirectoryExists($dirname, $visibility)
    {
        if (is_dir($dirname)) {

            return true;
        }

        if (!@mkdir($dirname, $visibility, true)) {

            if (!$this->errorHandler) {

                return false;
            }

            throw new UnableToCreateDirectory("Unable to create directory at path {$dirname}");
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function glob($pattern, $flags = 0)
    {
        if ($glob = glob($pattern, $flags) !== false) {

            return $glob;
        }

        if (!$this->errorHandler) {

            return false;
        }

        throw new UnableToReadFile("Unable to find pattern {$pattern}");
    }

    /**
     * Undocumented function
     *
     * @param string|null $visibility
     * @return integer
     */
    private function directoryVisibility($visibility = null)
    {
        return $visibility === null
            ? $this->provider->defaultDirectories()
            : $this->provider->invisibilityForDirectory($visibility);
    }

    /**
     * Undocumented function
     *
     * @param string $path
     * @param integer $mode
     * @return \Generator
     */
    private function listDirectoryRecursively(
        $path,
        $mode = \RecursiveIteratorIterator::SELF_FIRST
    ) {
        yield from new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS),
            $mode
        );
    }

    /**
     * Undocumented function
     *
     * @param object $file
     * @return boolean
     */
    private function autoDelete($file)
    {
        switch ($file->getType()) {
            case 'dir':
                return @rmdir((string) $file->getRealPath());
            case 'link':
                return @unlink((string) $file->getPathname());
            default:
                return @unlink((string) $file->getRealPath());
        }
    }

    /**
     * Undocumented function
     *
     * @param string $location
     * @return \Generator
     */
    private function listDirectory(string $location)
    {
        $iterator = new \DirectoryIterator($location);

        foreach ($iterator as $item) {

            if ($item->isDot()) {

                continue;
            }

            yield $item;
        }
    }
}
