<?php
namespace Dragon\Component\Security;

use Dragon\Component\Security\Token;
use Dragon\Component\Controller\AbstractAdminController;
use Dragon\Component\Security\Definition;
use Dragon\Component\Security\SecurityModel;
use Dragon\Component\Directory\Directory;
use Dragon\Component\Flash\FlashBag;
use Dragon\Component\Flash\FlashData;
use Dragon\Component\Mailer\Mailer;

class SecurityController extends AbstractAdminController
{
    private $app;
    private $config;

    public function __construct()
    {
        $this->app = getApp();
        $this->config = $this->app->security();
        
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
                return $this->loginStratregy_email();
                
            case Definition::STRATEGY_2FA:
                return $this->loginStratregy_2fa();
                
            default:
            case Definition::STRATEGY_PASSWORD:
                return $this->loginStratregy_password();
        }
    }

    /**
     * User authentication
     *
     * @return void
     */
    public function authentication()
    {
        switch ($this->config->get('strategy'))
        {
            case Definition::STRATEGY_EMAIL:
                return $this->authenticationStratregy_email();
                
            case Definition::STRATEGY_2FA:
                return $this->authenticationStratregy_2fa();
                
            default:
            case Definition::STRATEGY_PASSWORD:
                return $this->authenticationStratregy_password();
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
        $security = new SecurityModel;
        $tokenEngine = new Token;
        $request = $this->request();

        if ($request->isPost())
        {
            // Retrieve Post data
            // --

            $email = $request->request()->get('email');


            // Check Post data
            // --

            if (null == $email)
            {
                die("email field not found. " . __FILE__ . "-" . __LINE__);
            }


            // Check & Get user
            // --

            $user = $security->findByEmail( $email );

            if (!$user)
            {
                die("user not exists. " . __FILE__ . "-" . __LINE__);
            }


            // Generate Token
            // --

            // Generate the token
            $token = $tokenEngine->encode($user);

            // Set token data to $user
            $user->auth_token = $token->token;
            $user->auth_token_key = $token->key;
            $user->auth_token_create = $token->create_timestamp;
            $user->auth_token_expiration = $token->expire_timestamp;

            // Save $user
            if (!$security->putAuthToken($user))
            {
                die("Update token error. " . __FILE__ . "-" . __LINE__);
            }


            // Generate Email
            // --

            // Generate Login link
            $url = $this->generateUrl("_authentication", [
                'token' => urlencode($token->token),
            ], true);

          

            // dd($user);
            // // dd($email);

            // exit;

            $params = [
                'site_name' => getApp()->config()->get('title'),
                'firstname' => $user->firstname,
                'link' => $url,
            ];


            $mailer = new Mailer;
            
            $mailer
                ->addAddress($user->email, $user->fullname)
                ->addReplyTo( $this->app->mailer()->get('noreply') )
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

        if ($token = $request->query()->get('token'))
        {
            $token = urldecode($token);

            // Find user by token
            $user = $security->findByToken( $token );


            // Check the token
            if ($tokenEngine->decode($user, $token))
            {
                // Proceed to login
                $_SESSION['user'] = [
                    'id' => $user->id,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'screenname' => $user->screenname,
                    'email' => $user->email,
                ];

                // Set flashbag
                $this->flashbag->setFlashBag("success", "Welcome back $user->screenname.");

                // Return to Homepage
                $this->redirectToRoute("admin:homepage");
            }

            // Invalide token
            else
            {
                // Set flashbag
                $this->flashbag->setFlashBag("danger", "Invalid token...");

                // Return to login page
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

    private function authenticationStratregy_password()
    {
        echo "Authentication Password";
    }

    private function authenticationStratregy_email()
    {
        // $security = new SecurityModel;
        // $tokenEngine = new Token;

        // Retrieve Token
        // $token = $this->request()->query()->get('token');
        // $token = urldecode($token);

        // // Find user by token
        // $user = $security->findByToken( $token );


        // // Check the token
        // if ($tokenEngine->decode($user, $token))
        // {
        //     // Proceed to login
        //     $_SESSION['user'] = [
        //         'id' => $user->id,
        //         'firstname' => $user->firstname,
        //         'lastname' => $user->lastname,
        //         'screenname' => $user->screenname,
        //         'email' => $user->email,
        //     ];

        //     // Set flashbag
        //     $this->flashbag->setFlashBag("success", "Welcome back $user->screenname.");

        //     // Return to Homepage
        //     $this->redirectToRoute("homepage");
        // }

        // // Invalide token
        // else
        // {
        //     // Set flashbag
        //     $this->flashbag->setFlashBag("danger", "Invalid token...");

        //     // Return to login page
        //     $this->redirectToRoute("_login");
        // }
    }

    private function authenticationStratregy_2fa()
    {
        echo "Authentication 2FA";
    }
}
