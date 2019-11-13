<?php

namespace App\Controllers;


use App\Auth\Auth;
use App\Cookie\CookieJar;
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
    private $cookie;

    public function __construct(View $view, CookieJar $cookie)
    {
        $this->view = $view;
        $this->cookie = $cookie;
    }

    /**
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        dump($this->cookie->clear('abc', 'def'));

        $response = new Response();
        return $this->view->render($response, 'home.twig');

    }

}