<?php

foreach (scandir(__DIR__) as $item)
{
    $util_dir   = $item;
    $util_file  = $item.".php";

    $util_file  = __DIR__.DIRECTORY_SEPARATOR.$util_dir.DIRECTORY_SEPARATOR.$util_file;
    
    if (file_exists($util_file))
    {
        include_once $util_file;
    }
}