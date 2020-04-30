<?php
namespace Dragon\Component\Controller;

abstract class AbstractAdminController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->isGranted())
        {
            if( $this->request()->isXMLHttpRequest() ) 
            {
                header('HTTP/1.0 403 Forbidden');
                
                return false;
            }

            $this->redirectToRoute("_login");
        }
    }
}
