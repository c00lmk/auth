<?php


namespace App\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

class AppServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Router::class,
        'request',
        'emitter'
    ];

    public function register()
    {

        $container = $this->getContainer();

        // TODO check this 'link' to see if this issue has been resolved
        // https://github.com/thephpleague/container/issues/180

        $container->share(Router::class, function () use ($container) {

            $strategy = (new ApplicationStrategy())->setContainer($container);

            return (new Router)->setStrategy($strategy);
        });

        $container->share('request', function () {
            return ServerRequestFactory::fromGlobals(
                $_SERVER,
                $_GET,
                $_POST,
                $_COOKIE,
                $_FILES
            );
        });

        $container->share('emitter', function () {
            return new SapiEmitter();
        });
    }
}