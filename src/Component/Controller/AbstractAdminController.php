<?php
namespace Dragon\Component\Controller;

abstract class AbstractAdminController extends AbstractController
{
    public function __construct()
    {
        if (!$this->isGranted())
        {
            $this->redirectToRoute("_login");
        }
    }
}
