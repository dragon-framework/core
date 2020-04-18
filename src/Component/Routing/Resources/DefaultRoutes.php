<?php

use Dragon\Component\FileSystem\FileSystem;
$fs = new FileSystem;

$routes_Documentation = $fs->include(__DIR__."/../../Documentation/Routes.php");
$routes_Security = $fs->include(__DIR__."/../../Security/Routes.php");

return array_merge(
    $routes_Documentation,
    $routes_Security,
);
