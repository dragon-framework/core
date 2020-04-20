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
    public function getSender()
    {
        $sender = [];

        if (!empty($this->definition->get('sender_address')))
        {
            array_push($sender, $this->definition->get('sender_address'));
        }

        if (!empty($this->definition->get('sender_name')))
        {
            array_push($sender, $this->definition->get('sender_name'));
        }

        return $sender;
    }
    public function getSender_address()
    {
        return $this->definition->get('sender_address');
    }
    public function getSender_name()
    {
        return $this->definition->get('sender_name');
    }
    public function getNoreply()
    {
        return $this->definition->get('noreply');
    }
}