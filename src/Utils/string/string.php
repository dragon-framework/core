<?php

if (!function_exists("randstr"))
{
    /**
     * Generate a random string
     *
     * @param integer $length
     * @param boolean $lower
     * @param boolean $upper
     * @param boolean $numeric
     * @param boolean $special
     * @param string $additional
     * @return string
     */
    function randstr(int $length = 10, bool $lower=true, bool $upper=true, bool $numeric=true, bool $special=true, string $additional=''): string
    {
        // Characters Base
        $base_alpha   = "abcdefghijklmnopqrstuvwxyz";
        $base_upper   = strtoupper($base_alpha);
        $base_numeric = "0123456789";
        $base_special = "";

        // Base compilation
        $base = $lower ? $base_alpha : null;
        $base.= $upper ? $base_upper : null;
        $base.= $numeric ? $base_numeric : null;
        $base.= $special ? $base_special : null;
        $base.= $additional;

        $base = trim($base);
        $base_length = strlen($base);
        $random = '';

        for ($i = 0; $i < $length; $i++) 
        {
            $random .= $base[rand(0, $base_length - 1)];
        }

        return $random;
    }
}