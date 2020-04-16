<?php
namespace Dragon\Component\Security;

use Dragon\Component\Model\AbstractModel;

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
    public function findByEmail(string $email)
    {
        $this->findBy([
            $this->config->get('authentication_property') => $email
        ]);


        // dump( $email );
        // dump( "Find By Email" );
        // dump( $this );
    }
}