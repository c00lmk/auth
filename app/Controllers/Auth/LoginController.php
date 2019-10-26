<?php


namespace App\Controllers\Auth;


use App\Controllers\Controller;
use App\Views\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class LoginController extends Controller
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
    public function index(ServerRequestInterface $request): ResponseInterface
    {

        $response = new Response();
        return $this->view->render($response, 'auth/login.twig');

    }

    public function login(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        return $this->view->render($response, 'auth/login.twig');
    }

}