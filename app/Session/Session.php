<?php


namespace App\Session;


class Session implements SessionStore
{
    public function get($key, $defaul = NULL)
    {
        if($this->exists($key)) {
            return $_SESSION[$key];
        }

        return $defaul;
    }

    public function set($key, $value = NULL)
    {
        if (is_array($key)) {
            foreach ($key as $sessionKey => $sessionValue) {
                $_SESSION[$sessionKey] = $sessionValue;
            }

            return;
        }

        $_SESSION[$key] = $value;
    }

    public function exists($key)
    {
        return isset($_SESSION[$key]) && !empty($_SESSION[$key]);
    }

    public function clear(...$key)
    {
        foreach ($key as $sessionKey) {
            unset($_SESSION[$sessionKey]);
        }
    }


}