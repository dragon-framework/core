<?php
namespace Dragon\Component\Flash;

class FlashBag
{
    public function setFlashBag(string $state, string $message, bool $override=true): self
    {
        if (session_id())
        {
            if (!$override && isset($_SESSION['flashbag']))
            {
                return $this;
            }

            $_SESSION['flashbag'] = [
                'state' => $state,
                'message' => $message,
            ];
        }

        return $this;
    }

    public function hasFlashBag(): bool
    {
        return session_id() && isset($_SESSION['flashbag']);
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