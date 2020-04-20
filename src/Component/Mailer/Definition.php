<?php
namespace Dragon\Component\Mailer;

use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Definition
{
    /**
     * Mailer input definition file
     */
    const SOURCE = Directory::DIRECTORY_APP_CONFIG . "mailer/mailer.php";

    /**
     * Mailer final definition
     *
     * @var array
     */
    private $definitions = [];

    public function __construct()
    {
        $this->set();
    }

    /**
     * Mailer definition setter
     *
     * @return self
     */
    private function set(): self
    {
        $fs = new FileSystem;

        if ($fs->isFile(self::SOURCE))
        {
            $this->definitions = $fs->include( self::SOURCE ) ?? [];
        }

        return $this;
    }

    /**
     * Mailer definition getter
     *
     * @return array
     */
    public function get(?string $param = null)
    {
        return in_array($param, $this->definitions) 
            ? $this->definitions[ $param ] : null;
    }

}
