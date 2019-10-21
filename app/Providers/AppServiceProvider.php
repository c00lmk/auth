<?php


namespace App\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

class AppServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'test',
        Router::class,
        'response',
        'request',
        'emitter'
    ];

    public function register()
    {

        $container = $this->getContainer();

        // The following example shows how we can add things to the container
        // 1st step: add id via share methog
        // 2nd step: add protected property "$provides" as array and put in it whatever was add in #1 (in this example 'test')
        $container->share('test', function() {
            return 'it works';
        });
        // Ends example


        $container->share(Router::class, function() use ($container) {
            $strategy = new ApplicationStrategy();
            $strategy->setContainer($container);

            return (new Router)->setStrategy($strategy);
        });

        $container->share('response', Response::class);

        $container->share('request', function() {
            return ServerRequestFactory::fromGlobals(
                $_SERVER,
                $_GET,
                $_POST,
                $_COOKIE,
                $_FILES
            );
        });

        $container->share('emitter', function() {
            return new SapiEmitter();
        });
    }
}