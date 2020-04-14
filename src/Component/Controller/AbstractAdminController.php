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

    private function isGranted()
    {
        $routesExceptions = [
            "_login",
            "_pending",
            "_logout",
        ];

        $activeRoute = getApp()->routing()->get('active');

        if (in_array($activeRoute['name'], $routesExceptions))
        {
            return true;
        }

        return false;
    }
}
