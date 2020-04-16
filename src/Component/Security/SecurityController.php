<?php
namespace Dragon\Component\Security;

use Dragon\Component\Controller\AbstractAdminController;
use Dragon\Component\Security\Definition;
use Dragon\Component\Security\SecurityModel;
use Dragon\Component\Directory\Directory;
use Dragon\Component\Flash\FlashBag;
use Dragon\Component\Flash\FlashData;
use Dragon\Component\Mailer\Mailer;

class SecurityController extends AbstractAdminController
{
    private $config;

    public function __construct()
    {
        $this->config = getApp()->security();

        $this->flashbag = new FlashBag;
        $this->flashdata = new FlashData;
    }

    /**
     * Register a new user
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Login a user
     *
     * @return void
     */
    public function login()
    {
        switch ($this->config->get('strategy'))
        {
            case Definition::STRATEGY_EMAIL:
                return $this->loginStratregy_password();
        
            case Definition::STRATEGY_2FA:
                return $this->loginStratregy_email();
        
            default:
            case Definition::STRATEGY_PASSWORD:
                return $this->loginStratregy_2fa();
        }
    }

    /**
     * Logout
     *
     * @return void
     */
    public function logout()
    {
        session_destroy();
    
        $this->redirectToRoute( $this->config->get('logout_redirect') );
    }

    /**
     * Forgtten Password
     *
     * @return void
     */
    public function forgetPassword()
    {
    }

    /**
     * Reset Password
     *
     * @return void
     */
    public function resetPassword()
    {
    }



    private function loginStratregy_password()
    {
        echo "TODO: Strategy Password";
    }

    private function loginStratregy_email()
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

            $user = new SecurityModel;
            $user->findByEmail( $email );

            // dd($email);

            exit;

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

    private function loginStratregy_2fa()
    {
        echo "Strategy 2FA";
    }
}
