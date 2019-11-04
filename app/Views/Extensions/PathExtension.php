<?php


namespace App\Views\Extensions;

use League\Route\Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PathExtension extends AbstractExtension
{
    protected $router;

    public function __construct(Router $router)
    {

        $this->router = $router;
    }
    public function getFunctions()
    {
        return [
            new TwigFunction('route', [$this, 'route']),
        ];
    }

    public function route($name)
    {
        return $this->router->getNamedRoute($name)->getPath();
    }
}