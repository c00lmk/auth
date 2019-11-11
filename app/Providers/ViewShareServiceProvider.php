<?php

namespace App\Providers;


use App\Auth\Auth;
use App\Session\Flash;
use App\Views\View;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class ViewShareServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    protected $provides = [
        // Empty because we're not registering anything
    ];

    public function register()
    {
        //
    }

    public function boot()
    {
        $container = $this->getContainer();

        $container->get(View::class)->share([
            'config' => $container->get('config'),
            'auth' => $container->get(Auth::class),
            'flash' => $container->get(Flash::class)
        ]);
    }
}