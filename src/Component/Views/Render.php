<?php
namespace Dragon\Component\Views;

use Dragon\Component\Directory\Directory;

class Render
{
    public function __construct()
    {
        
    }

    public function render(string $template, array $params=array())
    {
        // Build the current Theme path
        // --

        $current_theme_name = getApp()->config()->get('theme');
        $current_theme_dir = Directory::DIRECTORY_THEMES . $current_theme_name;


        // Template Engine
        // --

        $loader = new \Twig\Loader\FilesystemLoader($current_theme_dir);
        $twig = new \Twig\Environment($loader, [
            // 'cache' => './path/to/compilation_cache',
        ]);

        return $twig->render($template, $params);
    }
}