<?php

namespace App\Controllers;


use App\Views\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class DashboardController
{

    /**
     * @var View
     */
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
        return $this->view->render($response, 'dashboard/index.twig');

    }

}