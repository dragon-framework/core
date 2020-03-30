<?php
namespace Dragon\Component\FileSystem;

class FileSystem
{
    /**
     * Include file if exists
     *
     * @param string $file
     * @return void
     */
    public function include(string $file)
    {
        return file_exists($file) ? include $file : null;
    }

    /**
     * Check if file exists
     *
     * @param string $file
     * @return boolean
     */
    public function isFile(string $file): bool
    {
        return file_exists($file);
    }
}