<?php


namespace App\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;

class AppServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'test'
    ];

    public function register()
    {
        // The following example shows how we can add things to the container
        // 1st step: add id via share methog
        // 2nd step: add protected property "$provides" as array and put in it whatever was add in #1 (in this example 'test')
        $container = $this->getContainer();

        $container->share('test', function() {
            return 'it works';
        });
    }
}