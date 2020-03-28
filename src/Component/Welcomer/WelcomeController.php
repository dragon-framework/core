<?php
namespace Dragon\Component\Welcomer;

use Dragon\Component\Controller\AbstractController;

class WelcomeController extends AbstractController
{
    public function welcome()
    {
        echo "Welcome to the Dragon";
    }
}