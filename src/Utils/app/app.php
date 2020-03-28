<?php

if (!function_exists('getApp'))
{
    function getApp()
    {
		if (!empty($GLOBALS['app'])){
			return $GLOBALS['app'];
		}

		return null;
    }
}