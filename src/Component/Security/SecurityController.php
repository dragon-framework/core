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
    private $securityModel;
    private $tokenEngine;

    public function __construct()
    {
        $this->app = getApp();

        $this->config = $this->app->security();
        $this->request = $this->request();

        $this->securityModel = new SecurityModel;
        $this->tokenEngine = new Token;
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
     * Activate user account
     *
     * @return void
     */
    public function activation()
    {
        return $this->activation_step2();
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
                
            default:
            case Definition::STRATEGY_PASSWORD:
            case Definition::STRATEGY_2FA:
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


    // Registration by strategy
    // --

    /**
     * Registration by strategy password or 2FA
     *
     * @return void
     */
    public function registerStratregy_password()
    {
        // Default values
        $firstname = $lastname = $email = null;

        if ($this->request->isPost())
        {
            $encoder = new Encoder;

            // Create empty errors array
            $errors = [];

            // Retrieve form data
            // --

            $firstname      = $this->request->request()->get('firstname');
            $lastname       = $this->request->request()->get('lastname');
            $email          = $this->request->request()->get('email');
            $password_text  = $this->request->request()->get('password');
            $confirm        = $this->request->request()->get('confirmPassword');
            $password_hash  = $encoder->encode($password_text);


            // Control form data
            // --

            // control firstname
            // Required + Must only contain letters, whitespace and dash
            if (null == $firstname)
            {
                $errors['firstname'] = "Firstname is required.";
            }
            if (!preg_match("/^[a-z](:?[a-z- ]){0,}[a-z]$/i", $firstname))
            {
                $errors['firstname'] = "Only contain letters, whitespace and dash.";
            }

            // control lastname
            // Required + Must only contain letters, whitespace and dash
            if (null == $lastname)
            {
                $errors['lastname'] = "Lastname is required.";
            }
            if (!preg_match("/^[a-z](:?[a-z- ]){0,}[a-z]$/i", $lastname))
            {
                $errors['lastname'] = "Only contain letters, whitespace and dash.";
            }

            // control email
            // Required + Must be an email address
            if (null == $email)
            {
                $errors['email'] = "Email is required.";
            }
            if (null != $email && !filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $errors['email'] = "Invalid email format.";
            }

            // control password
            // Required + Must contain at least:
            // - one lowercase letter
            // - one uppsercase letter
            // - one numerical char
            // - one special char
            if (null == $password_text)
            {
                $errors['password'] = "Password is required.";
            }
            else
            {
                if (!preg_match('@[a-z]@', $password_text))
                {
                    $errors['password'] = "Password must include at least one lower case letter.";
                }
                if (!preg_match('@[A-Z]@', $password_text))
                {
                    $errors['password'] = "Password must include at least one upper case letter.";
                }
                if (!preg_match('@[0-9]@', $password_text))
                {
                    $errors['password'] = "Password must include at least one number.";
                }
                if (!preg_match('@[^\w]@', $password_text))
                {
                    $errors['password'] = "Password must include at least one special char.";
                }
                if (strlen($password_text) < $this->config->get('password_min_lenght') )
                {
                    $errors['password'] = "Password too short.";
                }
            }

            // control password confirmation
            // Must the same of Password
            if ($confirm != $password_text)
            {
                $errors['confirm'] = "Passwords are not the same.";
            }


            // Check if user already exist
            // --

            if ($this->securityModel->findByEmail( $email ))
            {
                $errors['email'] = "An account using this email address is already registered";
            }
            // TODO : Check if user exist : By Username
            // TODO : Check if user exist : By Email Or Username


            // Save user data
            // --

            if (empty($errors))
            {
                $roles = array_merge($this->config->get('registration_default_roles'));

                // Save data in database
                $registration = $this->securityModel->insert([
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                    'password' => $password_hash,
                    'roles' => json_encode($roles),
                ]);

                // If save data error
                if (!$registration)
                {
                    $this->flashbag->setFlashBag('danger', "A database error as occurred...");
                }
                else 
                {

                    // Activation
                    // --

                    if ($this->config->get('activation'))
                    {
                        $this->activation_step1((object) [
                            'id' => $this->securityModel->lastId(),
                            'firstname' => $firstname,
                            'lastname' => $lastname,
                            'email' => $email,
                        ]);
                    }


                    // Auto login
                    // --

                    if ($this->config->get('authentication_on_registration'))
                    {
                        $this->autheticationStrategy_password($email, $password_text);
                    }


                    // Redirect
                    // --

                    $this->redirectToRoute( $this->config->get('redirect_on_registration') );
                }
            }


            // Error callback
            // --

            // Set Flash Data
            $this->flashdata->setFlashData([
                'errors' => $errors,
                'values' => [
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                ],
            ]);

            // Set Flash bag
            $this->flashbag->setFlashBag('danger', "There are some errors...", false);

            // Redirect
            $this->redirectToRoute('_register');
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


    // Login by strategy
    // --

    /**
     * Login by strategy password or 2FA
     *
     * @return void
     */
    private function loginStratregy_password()
    {
        if ($this->request->isPost())
        {
            // Retrieve form data
            // --

            $email          = $this->request->request()->get('login');
            $password_text  = $this->request->request()->get('password');
            

            // Authentication
            // --

            $this->autheticationStrategy_password($email, $password_text);
        }

        return $this->render("_security/pages/login-by-password.html", [
            'flashdata' => $this->flashdata->getFlashData()
        ]);
    }

    /**
     * Login by strategy email
     *
     * @return void
     */
    private function loginStratregy_email()
    {
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

            $user = $this->securityModel->findByEmail( $email );

            if (!$user)
            {
                die("user not exists. " . __FILE__ . "-" . __LINE__);
            }


            // Generate Token
            // --

            // Generate the token
            $token = $this->tokenEngine->encode($user, $this->config->get('authentication_token_expiration'));

            // Set token data to $user
            $user->auth_token = $token->token;
            $user->auth_token_key = $token->key;
            $user->auth_token_create = $token->create_timestamp;
            $user->auth_token_expiration = $token->expire_timestamp;

            // Save $user
            if (!$this->securityModel->putAuthToken($user))
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
                ->setSubject("[Authentication] Log in to ". $params['site_name'])
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
            $user = $this->securityModel->findByToken( $token );


            // Check the token
            if ($this->tokenEngine->decode($user, $token))
            {
                // Proceed to login
                $this->authenticate($user);

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

        return $this->render("_security/pages/login-by-email.html", [
            'flashdata' => $this->flashdata->getFlashData()
        ]);
    }


    // Authetication by strategy
    // --

    /**
     * Autheticate : Create user section in php Session
     *
     * @param object $user
     * @return boolean
     */
    private function authenticate(object $user): bool
    {
        if (session_id())
        {
            $roles = json_decode($user->roles, true);

            $_SESSION['user'] = [
                'id' => $user->id,
                'email' => $user->email,
                'roles' => $roles,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'screenname' => $user->screenname,
            ];

            return true;
        }

        return false;
    }

    /**
     * Proceed to authentication by password
     *
     * @param string $login
     * @param string $password
     * @return boolean
     */
    private function autheticationStrategy_password(string $login, string $password): bool
    {
        $encoder = new Encoder;

        // Retrieve User
        // --

        switch ($this->config->get('authentication_property'))
        {
            case 'email':
            $user = $this->securityModel->findByEmail($login, false);
            break;

            case 'username':
            $user = $this->securityModel->findByUsername($login, false);
            break;

            default:
            $user = $this->securityModel->findByEmailOrUsername($login, false);
            break;
        }

        // User not found on database
        if (!$user)
        {
            $this->flashbag->setFlashBag('danger', "Bad credential (1)");
            $this->redirectToRoute('_login');
        }


        // Verify password
        // --

        // If password is not verified
        if (!$encoder->verify($password, $user))
        {
            $this->flashbag->setFlashBag('danger', "Bad credential (2)");
            $this->redirectToRoute('_login'); 
        }


        // Authentication
        // --

        // Update Login Stats
        $this->securityModel->putLoginStats($user);

        // Proceed to authentication
        $this->authenticate($user);

        // redirect
        $this->redirectToRoute( $this->config->get('redirect_on_login') );
    }


    // Account activation
    // --

    private function activation_step1(object $user)
    {
        // Generate Token
        // --

        // Generate the token
        $token = $this->tokenEngine->encode($user, $this->config->get('activation_token_expiration'));

        // Set token data to $user
        $user->auth_token = $token->token;
        $user->auth_token_key = $token->key;
        $user->auth_token_create = $token->create_timestamp;
        $user->auth_token_expiration = $token->expire_timestamp;

        // Save $user
        if (!$this->securityModel->putAuthToken($user))
        {
            die("Update token error. " . __FILE__ . "-" . __LINE__);
        }


        // Generate Email
        // --

        // Generate Login link
        $url = $this->generateUrl("_activation", [
            'token' => urlencode($token->token),
        ], true);

        $params = [
            'site_name' => getApp()->config()->get('title'),
            'firstname' => $user->firstname,
            'link' => $url,
        ];


        $mailer = new Mailer;
        $mailer
            ->addAddress($user->email, $user->firstname." ".$user->lastname)
            ->addReplyTo( $this->app->mailer()->get('noreply') )
            ->setParams($params)
            ->setSubject("[Activation] Log in to ". $params['site_name'])
            ->setBodyTemplate("_security/email/activation.html")
            ->setAltBodyTemplate("_security/email/activation.txt")
            ->send()
        ;

        $this->flashbag->setFlashBag('info', "Check your mail box to activate your account");
    }

    private function activation_step2()
    {
        if ($token = $this->request->query()->get('token'))
        {
            $token = urldecode($token);

            // Find user by token
            $user = $this->securityModel->findByToken( $token );

            if (!$user)
            {
                // Set flashbag
                $this->flashbag->setFlashBag("info", "Your account is already actived.");

                // Return to login page
                $this->redirectToRoute("_login");
            }


            // Check the token
            if ($this->tokenEngine->decode($user, $token))
            {
                // Proceed to activation
                $this->securityModel->patchActivation($user);


                // Set flashbag
                $this->flashbag->setFlashBag("success", "Congratulation, your account is actived");

                // Redirect user
                $this->redirectToRoute( $this->config->get('redirect_on_activation') );

            }

            // Invalide token
            else
            {
                // Set flashbag
                $this->flashbag->setFlashBag("warning", "something goes wrong while activating the account.");

                // Return to login page
                $this->redirectToRoute("_login");
            }
        }
    }
}
