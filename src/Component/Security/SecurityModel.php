<?php
namespace Dragon\Component\Security;

use Dragon\Component\Model\AbstractModel;
use Dragon\Component\Database\Query;

class SecurityModel extends AbstractModel
{
    private $config;

    public function __construct()
    {
        parent::__construct();

        // Get the security config
        $this->config = getApp()->security();

        // Set security table
        $this->setTable( $this->config->get('table') );
    }

    /**
     * Find user by email
     *
     * @param string $email
     * @return void
     */
    public function findByEmail(string $email, bool $safe=true)
    {
        $result = $this->findBy([[
            'key'       => $this->config->get('authentication_property'),
            'value'     => $email,
            'type'      => Query::PARAM_STR,
            'relation'  => Query::EQUAL,
        ]]);

        if ($safe) unset($result->password);

        return $result;
    }

    /**
     * Find user by token
     *
     * @param string $token
     * @return void
     */
    public function findByToken(string $token, bool $safe=true)
    {
        $result = $this->findBy([[
            'key'       => "auth_token",
            'value'     => $token,
            'type'      => Query::PARAM_STR,
            'relation'  => Query::EQUAL,
        ]]);

        if ($safe) unset($result->password);

        return $result;
    }

    /**
     * Update Token data for a user
     *
     * @param object $user
     * @return void
     */
    public function putAuthToken(object $user)
    {
        return $this->update([
            Query::COLUMNS   => [
                'auth_token' => $user->auth_token,
                'auth_token_create' => $user->auth_token_create,
                'auth_token_expiration' => $user->auth_token_expiration,
                'auth_token_key' => $user->auth_token_key,
            ],
            Query::CRITERIAS => [
                'id' => $user->id
            ]
        ]);
    }

    /**
     * Update Login Stats
     *
     * @param object $user
     * @return void
     */
    public function putLoginStats(object $user)
    {
        $date = new \DateTime;
        $counter = (int) $user->login_counter + 1;

        return $this->update([
            Query::COLUMNS   => [
                'last_login_date' => $date->format("Y-m-d H:i:s"),
                'login_counter' => $counter,
            ],
            Query::CRITERIAS => [
                'id' => $user->id
            ]
        ]);
    }

    /**
     * Update activation data
     *
     * @param object $user
     * @return void
     */
    public function patchActivation(object $user)
    {
        $date = new \DateTime;

        return $this->update([
            Query::COLUMNS   => [
                'is_active' => 1,
                'activation_date' => $date->format("Y-m-d H:i:s"),
                'auth_token' => null,
                'auth_token_create' => null,
                'auth_token_expiration' => null,
                'auth_token_key' => null,
            ],
            Query::CRITERIAS => [
                'id' => $user->id
            ]
        ]);
    }
}