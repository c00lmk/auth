<?php

namespace App\Views;


use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class View
{
    protected $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render(ResponseInterface $response, $view, array $data = [])
    {
        $response->getBody()->write(
            $this->twig->render($view, $data)
        );

        return $response;

    }
}