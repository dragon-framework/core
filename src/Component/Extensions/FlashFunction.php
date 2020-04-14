<?php 
namespace Dragon\Component\Extensions;

use Dragon\Component\Flash\FlashBag;
use Dragon\Component\Flash\FlashData;

class FlashFunction
{
    private $flashbag;
    private $flashdata;

    public function __construct()
    {
        $this->flashbag = new FlashBag;
        $this->flashdata = new FlashData;
    }

    public function getFunctions(): array
    {
        return [
            'getFlashBag',
            'getFlashData'
        ];
    }

    public function getFlashBag()
    {
        return $this->flashbag->getFlashBag();
    }

    public function getFlashData()
    {
        return $this->flashdata->getFlashData();
    }
}