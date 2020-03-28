<?php

if (!function_exists('dump'))
{
    function dump($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}