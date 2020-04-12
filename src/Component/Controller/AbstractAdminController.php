<?php
namespace Dragon\Component\Controller;

abstract class AbstractAdminController extends AbstractController
{
    public function __construct()
    {
        if (!$this->isGranted())
        {
            $this->redirectToRoute("admin:security:login");
        }
    }

    private function isGranted()
    {
        $routesExceptions = [
            "admin:security:login",
            "admin:security:logout",
        ];

        $activeRoute = getApp()->routing()->get('active');

        if (in_array($activeRoute['name'], $routesExceptions))
        {
            return true;
        }

        return false;
    }
}
