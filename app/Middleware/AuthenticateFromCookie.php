<?php


namespace App\Middleware;


use App\Auth\Auth;
use App\Auth\Hashing\BcryptHasher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthenticateFromCookie implements MiddlewareInterface
{
    protected $session;

    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        if ($this->auth->check())
        {
            $response = $handler->handle($request);
            return $response;
        }

        if ($this->auth->hasRecaller()) {
            try {
                $this->auth->setUserFromCookie();
            } catch(\Exception $exception) {
                $this->auth->logout();
            }
        }

        $response = $handler->handle($request);
        return $response;

    }
}