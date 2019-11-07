<?php

namespace App\Controllers;


use App\Auth\Auth;
use App\Views\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class HomeController
{

    /**
     * @var View
     */
    protected $view;

    protected $auth;

    public function __construct(View $view, Auth $auth)
    {
        $this->view = $view;
        $this->auth = $auth;
    }

    /**
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        return $this->view->render($response, 'home.twig', [
            'user' => $this->auth->user()
        ]);

    }

}