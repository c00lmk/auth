<?php


namespace App\Security;


use App\Session\Session;

class Csrf
{
    private $persistToken = true;
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function token()
    {
        if (!$this->tokenNeedsToBeGenerated()) {
            return $this->getTokenFromSession();
        }
        $this->session->set(
            $this->Key(),
            $token = bin2hex(random_bytes(32))
        );

        return $token;
    }

    private function getTokenFromSession()
    {
        return $this->session->get($this->Key());
    }

    public  function Key()
    {
        return '_token';
    }

    private function tokenNeedsToBeGenerated()
    {
        if (!$this->session->exists($this->Key())) {
            return true;
        }
        if ($this->shouldPersistToken()) {
            return false;
        }

        return $this->session->exists($this->Key());
    }

    private function shouldPersistToken()
    {
        return $this->persistToken;
    }
}