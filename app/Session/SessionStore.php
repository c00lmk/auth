<?php


namespace App\Session;


interface SessionStore
{

    public function get($key, $defaul = NULL);

    public function set($key, $value = NULL);

    public function exists($key);

    public function clear(...$key);

}