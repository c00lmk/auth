<?php


namespace App\Providers;


use App\Auth\Hashing\Hasher;
use App\Auth\Providers\DatabaseProvider;
use App\Auth\Recaller;
use App\Cookie\CookieJar;
use App\Session\SessionStore;
use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use App\Auth\Auth;


class AuthServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Auth::class,
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(Auth::class, function () use ($container) {
            $provider = new DatabaseProvider();

            return new Auth(
                $container->get(Hasher::class),
                $container->get(SessionStore::class),
                new Recaller(),
                $container->get(CookieJar::class),
                $provider
            );
        });

    }
}