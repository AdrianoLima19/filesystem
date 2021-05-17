<?php

namespace Note\Filesystem;

use Note\Contracts\Filesystem\FilesystemProvider as ProviderContract;

/**
 * Class FilesystemProvider
 * 
 * @license MIT
 * @package Note\Filesystem
 */
class FilesystemProvider implements ProviderContract
{
    /**
     * Undocumented variable
     *
     * @var string
     */
    private $basePath;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $separator;

    /**
     * Undocumented variable
     *
     * @var integer
     */
    private $filePublic;

    /**
     * Undocumented variable
     *
     * @var integer
     */
    private $filePrivate;

    /**
     * Undocumented variable
     *
     * @var integer
     */
    private $directoryPublic;

    /**
     * Undocumented variable
     *
     * @var integer
     */
    private $directoryPrivate;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $defaultForDirectories;

    /**
     * Undocumented variable
     *
     * @var string 
     */
    public const PUBLIC = 'public';

    /**
     * Undocumented variable
     *
     * @var string
     */
    public const PRIVATE = 'private';

    /**
     * Undocumented function
     *
     * @param string $basePath
     * @param string $separator
     * @return void
     */
    public function __construct($basePath, $separator = '/')
    {
        $this->separator = (in_array($separator, ['\\', '/'])) ? $separator : DIRECTORY_SEPARATOR;

        $this->basePath = $this->normalizePath(rtrim($basePath, '\\/')) . $this->separator;

        $this->filePublic = 0644;
        $this->filePrivate = 0600;
        $this->directoryPublic = 0755;
        $this->directoryPrivate = 0700;
        $this->defaultForDirectories = self::PRIVATE;
    }

    /**
     * {@inheritDoc}
     */
    public function normalizePath($path)
    {
        $path = str_replace(['\\', '/'], $this->separator, $path);

        while (preg_match('#\p{C}+|^\./|^\../#u', $path)) {

            $path = (string) preg_replace('#\p{C}+|^\./|^\../#u', '', $path);
        }

        return $path;
    }

    /**
     * {@inheritDoc}
     */
    public function addPath($path)
    {
        return $this->basePath . $this->normalizePath(ltrim($path, '\\/'));
    }

    /**
     * {@inheritDoc}
     */
    public function removePath($path)
    {
        return substr($path, strlen($this->basePath));
    }

    /**
     * {@inheritDoc}
     */
    public function invisibilityForDirectory($visibility)
    {
        if (gettype($visibility) === "integer") {

            if ($visibility === $this->directoryPrivate) {

                return self::PRIVATE;
            }

            return self::PUBLIC;
        }

        if (in_array(strtolower($visibility), [self::PRIVATE, self::PUBLIC])) {

            if (strtolower($visibility) === self::PRIVATE) {

                return $this->directoryPrivate;
            }

            return $this->directoryPublic;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function invisibilityForFile($visibility)
    {
        if (gettype($visibility) === "integer") {

            if ($visibility === $this->filePrivate) {

                return self::PRIVATE;
            }

            return self::PUBLIC; // default
        }

        if (in_array(strtolower($visibility), [self::PRIVATE, self::PUBLIC])) {

            if (strtolower($visibility) === self::PRIVATE) {

                return $this->filePrivate;
            }

            return $this->filePublic;
        }

        throw new \Exception("invisibility must be either " . self::class . "::PUBLIC or " . self::class . "::PRIVATE", 1);
    }

    /**
     * {@inheritDoc}
     */
    public function defaultDirectories()
    {
        return $this->defaultForDirectories === self::PUBLIC ? $this->directoryPublic : $this->directoryPrivate;
    }

    /**
     * {@inheritDoc}
     */
    public function setPermissions($permissions = [])
    {
        $this->filePublic = $permissions['file']['public'] ?? 0644;
        $this->filePrivate = $permissions['file']['private'] ?? 0600;
        $this->directoryPublic = $permissions['dir']['public'] ?? 0755;
        $this->directoryPrivate = $permissions['dir']['private'] ?? 0700;
        $this->defaultForDirectories = $permissions['dir']['default'] ?? self::PRIVATE;
    }
}
