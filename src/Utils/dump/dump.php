<?php

if (!function_exists('dump'))
{
    function dump($data)
    {
        $traces = debug_backtrace();
        $caller = $traces[0];

        $called_at_file = $caller['file'];
        $called_at_line = $caller['line'];

        $type = gettype($data);

        echo '<pre style="padding: 10px; font-family: Consolas, Monospace; background-color: #000; color: #FFF;">';
        echo '<div style="color: #F00; margin-bottom: 16px;">'.$called_at_file.' <span style="color: #0F0;">line: '.$called_at_line.'</span></div>';

        // Dump Type
        echo '<span style="color: #B729D9; margin-bottom: 16px;">';
        echo $type;
        switch ($type)
        {
            case 'array':
                echo '('.count($data).')';
            break;
        }
        echo '</span> ';

        // Dump data
        switch ($type)
        {
            case 'boolean':
                echo $data ? "true" : "false";
            break;

            default:
                print_r($data);
        }
        echo '</pre>';
    }

}

if (!function_exists('dd'))
{
    function dd($data)
    {
        dump($data);
        die;
    }
}