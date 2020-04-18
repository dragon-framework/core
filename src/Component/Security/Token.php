<?php
namespace Dragon\Component\Security;

class Token
{
    const SYMBOLE               = "\\";
    const KEY_LENGTH            = 10;

    const CODE_NO_ERROR         = 0;
    const CODE_MATCHING_ERROR   = 1;
    const CODE_EXPIRED          = 2;

    private $config;
    private $date;

    private $dateCreate;
    private $dateExpire;

    private $expiration;

    public function __construct()
    {
        $app = getApp();

        $this->config = $app->security();
        $this->date = new \DateTime();
        $this->expiration = $this->config->get('token_expiration');

        $this
            ->setDateCreate()
            ->setDateExpire()
        ;
    }

    private function setDateCreate(): self
    {
        $this->dateCreate = $this->date;

        return $this;
    }
    private function getDateCreate(): \DateTime
    {
        return $this->dateCreate;
    }
    private function getTimestampCreate(): string
    {
        return $this->dateCreate->getTimestamp();
    }

    private function setDateExpire(): self
    {
        $this->dateExpire = clone $this->date;
        $this->dateExpire->add( $this->getExpirationPeriod() );

        return $this;
    }
    private function getDateExpire(): \DateTime
    {
        return $this->dateExpire;
    }
    private function getTimestampExpire(): string
    {
        return $this->dateExpire->getTimestamp();
    }

    private function getExpirationTime(): int
    {
        return $this->expiration;
    }
    private function getExpirationPeriod(): \DateInterval
    {
        $period = $this->getExpirationTime();
        $period = "PT".$period."S";

        return new \DateInterval($period);
    }

    public function encode(object $user): object
    {
        $key_primary = randstr( self::KEY_LENGTH );
        $secondary_key = randstr( self::KEY_LENGTH );
        $md5_timestamp_create = md5( $this->getTimestampCreate() );
        $md5_email = md5($user->email);
        $md5_id = md5($user->id);
        $md5_key = md5($key_primary);

        $token = $key_primary . md5($md5_timestamp_create . $md5_email . $md5_id . $md5_key);

        // dump($token);

        $token_length = strlen($token);
        $secondary_key_length = strlen($secondary_key);
        $divider = floor($token_length/$secondary_key_length);

        $splitted_token = [];

        $j=0;
        for ($i=0; $i<$token_length; $i++)
        {
            if ($i%$divider == 0)
            {
                $tt = isset($secondary_key[$j]) ? $secondary_key[$j] : null;
                array_push( $splitted_token, $tt. substr($token, $i, $divider) );
                $j++;
            }
        }

        $token = implode('', $splitted_token);//."-".$divider;

        $part1 = substr($token, 0, $divider);
        $part2 = substr($token, $divider);

        $token = $part1.self::SYMBOLE.$part2;

        // dump( $token_length );
        // dump( $secondary_key_length );
        // dump( $divider );
        // dump( $splitted_token );

        // dump( $token );
        
        return (object) [
            'token'             => $token,
            'key'               => $secondary_key,
            'create_date'       => $this->getDateCreate(),
            'create_timestamp'  => $this->getTimestampCreate(),
            'expire_date'       => $this->getDateExpire(),
            'expire_timestamp'  => $this->getTimestampExpire(),
        ];
    }

    public function decode(object $user, string $token): bool
    {
        // Default code : 0 No Error
        $code = self::CODE_NO_ERROR;

        // Check if the token matchin in user data
        // If not, set the code : 1 Matching Error
        if ($user->auth_token != $token)
        {
            $code = self::CODE_MATCHING_ERROR;
        }

        // Check expiration
        // dump( $this->date->getTimestamp()-$user->auth_token_expiration > 0);
        if ( $user->auth_token_expiration-$this->date->getTimestamp() < 0 )
        {
            $code = self::CODE_EXPIRED; 
        }


        // dump( $user->auth_token_expiration );
        // dump( $this->date->getTimestamp() );
        // dump( "Code : " . $code );

        // Get divider
        $token = explode(self::SYMBOLE, $token);
        $divider = strlen($token[0]);
        $token = implode($token);

        $key = null;
        $parts = str_split($token, $divider+1);

        foreach ($parts as $k => $part)
        {
            if (strlen($key) < self::KEY_LENGTH)
            {
                $key.= substr($part, 0, 1);

                $parts[$k] = substr($part, 1);
            }
        }

        $token = implode($parts);

        // Get primary key
        $primary_key = substr($token, 0, self::KEY_LENGTH);
        $md5_key = md5($primary_key);

        // Remove primary key
        $md5_token = substr($token, self::KEY_LENGTH);

        $md5_email = md5( $user->email );
        $md5_id = md5( $user->id );
        $md5_timestamp_create = md5($user->auth_token_create);



        $verirf = md5($md5_timestamp_create . $md5_email . $md5_id . $md5_key);



        return $code == self::CODE_NO_ERROR ? $md5_token === $verirf : false;
    }

    public function verify(): bool
    {
        return true;
    }
}