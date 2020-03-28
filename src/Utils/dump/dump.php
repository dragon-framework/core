<?php

if (!function_exists('dump'))
{
    function dump($data)
    {
		echo '<pre style="padding: 10px; font-family: Consolas, Monospace; background-color: #000; color: #FFF;">';
        print_r($data);
        echo '</pre>';
    }
}