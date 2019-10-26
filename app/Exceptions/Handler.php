<?php


namespace App\Exceptions;




use App\Session\SessionStore;

class Handler
{

    protected $exception;
    protected $session;

    public function __construct(
        \Exception $exception,
        SessionStore $session
    )
    {
        $this->exception = $exception;
        $this->session = $session;
    }

    public function respond()
    {
        $class = (new \ReflectionClass($this->exception))->getShortName();

        if (method_exists($this, $method = "handle{$class}"))
        {
            return $this->{$method}($this->exception);
        }

        return $this->unhandledException($this->exception);

    }

    public function handleValidationException(ValidationException $exception)
    {
        // session set
        $this->session->set([
            'errors' => $exception->getErrors(),
            'old' => $exception->getOldInput()
        ]);

        // redirect
        return redirect($exception->getPath());

    }

    public function unhandledException(ValidationException $exception)
    {
        throw $exception;
    }
}