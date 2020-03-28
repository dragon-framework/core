<?php 
namespace Dragon\Component\Controller;

use Dragon\Component\Directory\Directory;

abstract class AbstractController 
{
    protected function render(string $template, array $params=[])
    {
        $themes_dir     = Directory::DIRECTORY_THEMES;
        $theme_name     = getApp()->config()->getConfig('theme');
        $theme_dir      = $themes_dir.$theme_name;

        $loader = new \Twig\Loader\FilesystemLoader($theme_dir);
        $twig = new \Twig\Environment($loader, [
            // 'cache' => './path/to/compilation_cache',
        ]);

        echo $twig->render($template, $params);
    }
}