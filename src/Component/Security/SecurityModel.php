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
}
