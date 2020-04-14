<?php
namespace Dragon\Component\Security;

use Dragon\Component\Controller\AbstractAdminController;
use Dragon\Component\Directory\Directory;
use Dragon\Component\Flash\FlashBag;
use Dragon\Component\Flash\FlashData;
use Dragon\Component\Mailer\Mailer;

class Controller extends AbstractAdminController
{
    public function __construct()
    {
        $this->flashbag = new FlashBag;
        $this->flashdata = new FlashData;
    }

    public function register()
    {
    }

    public function login()
    {
        if ($this->request()->isPost())
        {
            $hasError = false;


            // Retrieve Post data
            // --

            $email = $this->request()->request()->get('email');


            // Check Post data
            // --

            if (null == $email)
            {
                // todo: message error
                $hasError = true;
            }


            // Check & Get user
            // --

            $user = [
                'email' => $email,
                'firstname' => "Bruce",
                'lastname' => "WAYNE",
                'fullname' => "Bruce WAYNE",
            ];
            $params = [
                'site_name' => getApp()->config()->get('title'),
                'firstname' => $user['firstname'],
            ];

            // dump( $email );
            // dump( $user );
            // dump( $params );
            // exit;



            if (!$hasError)
            {
                $mailer = new Mailer;
                
                $mailer
                    ->addAddress($user['email'], $user['fullname'])
                    ->addReplyTo( getApp()->mailer()->get('noreply') )
                    ->setParams($params)
                    ->setSubject("[Dragon Auth] Log in to ". $params['site_name'])
                    ->setBodyTemplate("_security/email/auth-step-1.html")
                    ->setAltBodyTemplate("_security/email/auth-step-1.txt")
                    ->send()
                ;

                // Set Flash data
                
                $this->flashdata->setFlashData(['login-state' => "onTheWay"]);

                // Redirect the user
                $this->redirectToRoute("_login");
            }
        }

        return $this->render("_security/pages/login.html", [
            'flashdata' => $this->flashdata->getFlashData()
        ]);
    }

    public function logout()
    {
    }

    public function forgetPassword()
    {
    }

    public function resetPassword()
    {
    }
}
