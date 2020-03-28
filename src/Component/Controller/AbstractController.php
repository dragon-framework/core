<?php 
namespace Dragon\Component\Controller;

abstract class AbstractController 
{
    protected function render(string $template, array $params=[])
    {
        $loader = new \Twig\Loader\FilesystemLoader('../src/Themes');
        $twig = new \Twig\Environment($loader, [
            // 'cache' => './path/to/compilation_cache',
        ]);

        echo $twig->render($template, $params);
    }
}