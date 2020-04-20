<?php
namespace Dragon\Component\Mailer;

use Dragon\Component\Directory\Directory;
use Dragon\Component\Views\Render;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private $mail;
    private $config;

    private $from;
    private $params = [];

    public function __construct()
    {
        $this->config = getApp()->mailer();
        
        $this->mail = new PHPMailer;
        $this->mail->isHTML(true); // force all mail has HTML !
    }

    private function settings(): self 
    {
        $this
            ->transport()
            ->host()
            ->auth()
            ->username()
            ->password()
            ->secure()
            ->port()
        ;

        return $this;
    }

    private function transport(): self
    {
        switch ($this->config->get('transport'))
        {
            case 'smtp':
                $this->mail->isSMTP();
                break;
        }

        return $this;
    }

    private function host(): self
    {
        $this->mail->Host = $this->config->get('host');

        return $this;
    }

    private function auth(): self
    {
        switch ($this->config->get('transport'))
        {
            case 'smtp':
                $this->mail->SMTPAuth = $this->config->get('auth'); 
                break;
        }

        return $this;
    }

    private function username(): self
    {
        $this->mail->Username = $this->config->get('username'); 

        return $this;
    }

    private function password(): self
    {
        $this->mail->Password = $this->config->get('password'); 
        
        return $this;
    }

    private function secure(): self
    {
        if ($this->config->get('tls'))
        {
            switch ($this->config->get('transport'))
            {
                case 'smtp':
                    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    break;
            }
        }

        return $this;
    }

    private function port(): self
    {
        $this->mail->Port = $this->config->get('port'); 

        return $this;
    }

    private function sender(): self
    {
        $sender = $this->from ?? $this->config->get('sender');

        if (!empty($sender))
        {
            $this->mail->setFrom($sender[0], $sender[1]);
        }
        
        return $this;
    }

    private function setTemplate(string $template): string
    {
        $render = new Render;

        return $render->render($template, $this->params);
    }



    public function setFrom(string $address, ?string $name=null): self
    {
        $this->from = [$address, $name];

        return $this;
    }

    public function addAddress(string $address, ?string $name=null): self
    {
        $this->mail->addAddress($address, $name);

        return $this;
    }

    public function addReplyTo(string $address, ?string $name=null): self
    {
        $this->mail->addReplyTo($address, $name);

        return $this;
    }

    public function addCC(string $address, ?string $name=null): self
    {
        $this->mail->addCC($address, $name);

        return $this;
    }

    public function addBCC(string $address, ?string $name=null): self
    {
        $this->mail->addBCC($address, $name);

        return $this;
    }

    public function addAttachment(string $file, ?string $name=null): self
    {
        $this->mail->addAttachment($file, $name);

        return $this;
    }


    public function setSubject(string $subject): self
    {
        $this->mail->Subject = $subject;

        $this->params = array_merge($this->params, ['subject' => $subject]);

        return $this;
    }

    public function setParams(array $params=[]): self
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    public function setBody(string $content): self
    {
        $this->mail->Body = utf8_decode($content);

        return $this;
    }
    public function setBodyTemplate(string $template): self
    {
        $this->setBody( $this->setTemplate($template) );

        return $this;
    }

    public function setAltBody(string $content): self
    {
        $this->mail->AltBody = $content;

        return $this;
    }
    public function setAltBodyTemplate(string $template): self
    {
        $this->setAltBody( $this->setTemplate($template) );

        return $this;
    }

    public function send()
    {
        try 
        {
            $this->settings();
            $this->sender();
            $this->mail->send();
        } 
        catch(Exception $e) 
        {
            throw new \Exception( $e->getMessage() );
        }
    }
}
