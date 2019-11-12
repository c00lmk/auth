<?php


namespace App\Exceptions;


use Psr\Http\Message\ServerRequestInterface;

class CsrfTokenException extends \Exception
{


    public function __construct()
    {

    }

}