<?php
namespace Dragon\Component\Security;

class Encoder
{
    private $algorithm;

    public function __construct()
    {
        $this->setAlgorithm();
    }
    
    public function setAlgorithm(): self
    {
        switch (getApp()->security()->get('password_encoder'))
        {
            case 'bcrypt':
                $this->algorithm = PASSWORD_BCRYPT;
            break;

            case 'argon2i':
                $this->algorithm = PASSWORD_ARGON2I;
            break;

            case 'argon2i':
                $this->algorithm = PASSWORD_ARGON2ID;
            break;

            default:
            case 'default':
                $this->algorithm = PASSWORD_DEFAULT;
        }

        return $this;
    }

    public function encode(string $password): string
    {
        return password_hash($password, $this->algorithm);
    }

    public function verify(string $password , object $user): bool
    {
        return password_verify($password, $user->password);
    }
}