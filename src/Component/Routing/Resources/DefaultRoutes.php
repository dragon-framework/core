<?php

$fs = new Dragon\Component\FileSystem\FileSystem;

return array_merge(

    // Documentation routes
    $fs->include(__DIR__."/../../Documentation/Routes.php") ?? [],

    // Security routes
    // $fs->include(__DIR__."/../../Security/Routes.php") ?? [],

);
