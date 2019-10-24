<?php


namespace App\Controllers\Auth;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class LoginController
{
    protected $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        return $this->view->render($response, 'auth/login.twig');

    }

}