<?php

namespace App\Controllers;


use App\Auth\Hashing\Hasher;
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
    protected $db;

    public function __construct(View $view, Hasher $hasher)
    {
        $this->view = $view;
        $this->hash = $hasher;
    }

    /**
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        return $this->view->render($response, 'home.twig');

    }

}