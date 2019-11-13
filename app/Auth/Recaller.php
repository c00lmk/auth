<?php


namespace App\Auth;


class Recaller
{
    private $separator = "|";
    public function generate()
    {
        return [
            $this->generateIdentifier(), $this->generateToken()
        ];
    }

    protected function generateIdentifier()
    {
        return bin2hex(random_bytes(32));
    }
    protected function generateToken()
    {
        return bin2hex(random_bytes(32));
    }

    public function generateValueForCookie($identified, $token)
    {
        return $identified . $this->separator . $token;
    }

    public function getTokenHashForDatabase($token)
    {
        return hash('sha3-256', $token);
    }

    public function splitCookieValue($value)
    {
        return explode($this->separator, $value);
    }

    public function validateToken($plain, $hash)
    {
        return $this->getTokenHashForDatabase($plain) === $hash;
    }
}