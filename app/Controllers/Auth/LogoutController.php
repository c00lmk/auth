<?php


namespace App\Controllers\Auth;


use App\Auth\Auth;
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class LogoutController extends Controller
{
    private $auth;
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function logout(ServerRequestInterface $request): ResponseInterface
    {

        $this->auth->logut();

        $response = redirect('/');
        return $response;

    }


}