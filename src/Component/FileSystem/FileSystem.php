<?php
namespace Dragon\Component\FileSystem;

class FileSystem
{
    public function include(string $file)
    {
        return file_exists($file) ? include $file : null;
    }
}