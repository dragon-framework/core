<?php
namespace Dragon\Component\Mailer;

use Dragon\Component\Mailer\Definition;

class Builder
{

    /**
     * Routes definition
     *
     * @var \Definition
     */
    private $definition;

    public function __construct()
    {
        $this->definition = new Definition;
    }

    public function getTransport()
    {
        return $this->definition->get('transport');
    }
    public function getAuth()
    {
        return $this->definition->get('auth');
    }
    public function getTls()
    {
        return $this->definition->get('tls');
    }
    public function getHost()
    {
        return $this->definition->get('host');
    }
    public function getUsername()
    {
        return $this->definition->get('username');
    }
    public function getPassword()
    {
        return $this->definition->get('password');
    }
    public function getPort()
    {
        return $this->definition->get('port');
    }
    public function getExpeditor()
    {
        $expeditor = [];

        if (!empty($this->definition->get('from_address')))
        {
            array_push($expeditor, $this->definition->get('from_address'));
        }

        if (!empty($this->definition->get('from_name')))
        {
            array_push($expeditor, $this->definition->get('from_name'));
        }

        return $expeditor;
    }
    public function getNoreply()
    {
        return $this->definition->get('noreply');
    }
}