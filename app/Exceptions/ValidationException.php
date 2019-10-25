<?php


namespace App\Exceptions;


use Psr\Http\Message\ServerRequestInterface;

class ValidationException extends \Exception
{
    private $request;
    private $errors;

    public function __construct(ServerRequestInterface$request, array $errors)
    {
        $this->request = $request;
        $this->errors = $errors;
    }

    public function getPath()
    {
        return $this->request->getUri()->getPath();
    }

    public function getOldInput()
    {
        return $this->request->getParsedBody();
    }

    public function getErrors()
    {
        return $this->errors;
    }
}