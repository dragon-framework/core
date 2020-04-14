<?php
namespace Dragon\Component\Flash;

class FlashData
{
    public function setFlashData(array $data): self
    {
        if (session_id())
        {
            if (!isset($_SESSION['flashdata']) || !is_array($_SESSION['flashdata']))
            {
                $_SESSION['flashdata'] = [];
            }

            $_SESSION['flashdata'] = array_merge($_SESSION['flashdata'], $data);
        }

        return $this;
    }

    public function getFlashData(): array
    {
        $data = [];
        
        if (isset($_SESSION['flashdata']))
        {
            $data = $_SESSION['flashdata'];

            unset($_SESSION['flashdata']);
        }
        
        return $data;
    }
}