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
            $this->key(),
            $token = bin2hex(random_bytes(32))
        );

        return $token;
    }

    private function getTokenFromSession()
    {
        return $this->session->get($this->key());
    }

    public  function key()
    {
        return '_token';
    }

    public function tokenIsValid($token)
    {
        return $token === $this->session->get($this->key());
    }

    private function tokenNeedsToBeGenerated()
    {
        if (!$this->session->exists($this->key())) {
            return true;
        }
        if ($this->shouldPersistToken()) {
            return false;
        }

        return $this->session->exists($this->key());
    }

    private function shouldPersistToken()
    {
        return $this->persistToken;
    }
}