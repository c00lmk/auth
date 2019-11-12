<?php


namespace App\Exceptions;




use App\Session\SessionStore;
use App\Views\View;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

class Handler
{

    protected $exception;
    protected $session;
    private $view;

    public function __construct(
        \Exception $exception,
        SessionStore $session,
        View $view
    )
    {
        $this->exception = $exception;
        $this->session = $session;
        $this->view = $view;
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

    public function handleCsrfTokenException(\Exception $exception)
    {
        $response = new Response();
        return $this->view->render($response, 'errors/csrf.twig');
    }
    public function unhandledException(\Exception $exception)
    {
        throw $exception;
    }
}