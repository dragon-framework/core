<?php
namespace Dragon\Component\Flash;

class FlashBag
{
    public function setFlashBag(string $state, string $message): self
    {
        if (session_id())
        {
            $_SESSION['flashbag'] = [
                'state' => $state,
                'message' => $message,
            ];
        }

        return $this;
    }

    public function getFlashBag(): array
    {
        $data = [];

        if (isset($_SESSION['flashbag']))
        {
            $data = $_SESSION['flashbag'];

            unset($_SESSION['flashbag']);
        }
        
        return $data;
    }
}