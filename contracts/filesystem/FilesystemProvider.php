<?php

declare(strict_types=1);

namespace Note\Contracts\Filesystem;

/**
 * Interface FilesystemProvider
 * 
 * @license MIT
 * @package Note\Contracts\Filesystem
 */
interface FilesystemProvider
{
    /**
     * Undocumented function
     *
     * @param string $path
     * @return string
     */
    public function normalizePath($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string
     */
    public function addPath($path);

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string
     */
    public function removePath($path);

    /**
     * Undocumented function
     *
     * @param string|integer $visibility
     * @return string|integer
     */
    public function invisibilityForDirectory($visibility);

    /**
     * Undocumented function
     *
     * @param string|integer $visibility
     * @return string|integer
     * 
     * @throws \Exception
     */
    public function invisibilityForFile($visibility);

    /**
     * Undocumented function
     *
     * @return integer
     */
    public function defaultDirectories();

    /**
     * Undocumented function
     *
     * @param array $permissions
     * @return void
     */
    public function setPermissions($permissions = []);
}
