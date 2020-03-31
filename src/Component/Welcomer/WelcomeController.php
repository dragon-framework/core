<?php
namespace Dragon\Component\Welcomer;

class WelcomeController
{
    public function welcome()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__);
        $twig = new \Twig\Environment($loader, [
            // 'cache' => './path/to/compilation_cache',
        ]);

        echo $twig->render('welcome.html', [
            'version' => "0.0.1"
        ]);

    }
}