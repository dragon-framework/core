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
use Dragon\Component\Errors\Error404\Controller as Error404;

class SecurityController extends AbstractAdminController
{
    private $app;
    private $config;
    private $request;

    public function __construct()
    {
        $this->app = getApp();
        $this->config = $this->app->security();

        $this->request = $this->request();
        
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
        // If registration not allowed
        if (!$this->config->get('registration_allowed'))
        {
            $error404 = new Error404;
            $error404->render();
        }

        // If user already loged in
        if ($this->user())
        {
            $this->redirectToRoute( $this->config->get('redirect_on_login') );
        }

        // Switch register controller by strategy
        switch ($this->config->get('strategy'))
        {
            case Definition::STRATEGY_EMAIL:
                return $this->registerStratregy_email();
                
            default:
            case Definition::STRATEGY_PASSWORD:
            case Definition::STRATEGY_2FA:
                return $this->registerStratregy_password();
        }
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
     * Logout
     *
     * @return void
     */
    public function logout()
    {
        session_destroy();
    
        $this->redirectToRoute( $this->config->get('redirect_on_logout') );
    }

    /**
     * Forgtten Username
     *
     * @return void
     */
    public function forgetUsername()
    {
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

        if ($this->request->isPost())
        {
            // Retrieve Post data
            // --

            $email = $this->request->request()->get('email');


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

        if ($token = $this->request->query()->get('token'))
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
                    'email' => $user->email,
                    'roles' => $user->roles,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'screenname' => $user->screenname,
                ];

                // Set flashbag
                $this->flashbag->setFlashBag("success", "Welcome back $user->screenname.");

                // Redirect user
                $this->redirectToRoute( $this->config->get('redirect_on_login') );

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


    /**
     * Registration by strategy password or 2FA
     *
     * @return void
     */
    public function registerStratregy_password()
    {
        if ($this->request->isPost())
        {
            // Retrieve form data
            // --

            // Check form data
            // --

            // Check if user already exist
            // --

            // Save user data
            // --

            
        }

        return $this->render("_security/pages/register-by-password.html");
    }

    /**
     * Registration by strategy email
     *
     * @return void
     */
    public function registerStratregy_email()
    {
        if ($this->request->isPost())
        {
        }

        return $this->render("_security/pages/register-by-email.html");
    }
}
