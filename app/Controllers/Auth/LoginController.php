<?php


namespace App\Controllers\Auth;


use App\Auth\Auth;
use App\Controllers\Controller;
use App\Session\Flash;
use App\Views\View;
use League\Route\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class LoginController extends Controller
{
    protected $view;
    protected $auth;
    protected $router;
    protected $flash;

    public function __construct(View $view, Auth $auth, Router $router, Flash $flash)
    {
        $this->view = $view;
        $this->auth = $auth;
        $this->router = $router;
        $this->flash = $flash;
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

        $data = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $attempt = $this->auth->attempt($data['email'], $data['password']);

        if(!$attempt) {
            $this->flash->now('error', 'Could not sign in with those details.');

            return redirect($request->getUri()->getPath());

        }
        return redirect($this->router->getNamedRoute('home')->getPath());

        //return $this->view->render($response, 'auth/login.twig');
    }

}