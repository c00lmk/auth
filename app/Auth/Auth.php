<?php


namespace App\Auth;


use App\Auth\Hashing\Hasher;
use App\Auth\Providers\UserProvider;
use App\Cookie\CookieJar;
use App\Session\SessionStore;

class Auth
{

    protected $hasher;

    protected $session;

    private $user;

    private $recaller;

    private $cookie;

    private $provider;

    public function __construct(
        Hasher $hasher,
        SessionStore $session,
        Recaller $recaller,
        CookieJar $cookie,
        UserProvider $user
    )
    {
        $this->hasher = $hasher;
        $this->session = $session;
        $this->recaller = $recaller;
        $this->cookie = $cookie;
        $this->provider = $user;
    }

    public function attempt($username, $password, $remember = false)
    {
        $user = $this->provider->getByUsername($username);

        if (!$user || !$this->hasValidCredentials($user, $password)) {
            return false;
        }

        if($this->needsRehash($user)){
            $this->provider->updateUserPasswordHash($user->id, $this->hasher->create($password));
        }

        $this->setUserSession($user);

        if ($remember) {
            $this->setRememberToken($user);
        }
        return true;
    }

    protected function key()
    {
        return 'id';
    }

    protected function hasValidCredentials($user, $password)
    {
        return $this->hasher->check($password, $user->password);
    }


    protected function setUserSession($user)
    {
        $this->session->set($this->key(), $user->id);
    }

    public function user()
    {
        return $this->user;
    }

    public function hasUserInSession()
    {
        return $this->session->exists($this->key());
    }

    public function setUserFromSession()
    {
        $user = $this->provider->getById($this->session->get($this->key()));

        if (!$user) {
            throw new \Exception();
        }

        $this->user = $user;
    }

    public function check()
    {
        return $this->hasUserInSession();
    }

    public function needsRehash($user)
    {
        return $this->hasher->needsRehash($user->password);
    }


    public function logout()
    {
        $this->provider->clearUserRememberToken($this->user->id);
        $this->session->clear($this->key());
        $this->cookie->clear('remember');
    }

    private function setRememberToken($user)
    {
        list($identifier, $token) = $this->recaller->generate();

        $this->cookie->set('remember', $this->recaller->generateValueForCookie($identifier, $token));

        $this->provider->setUserRememberToken($user->id, $identifier, $this->recaller->getTokenHashForDatabase($token));
    }

    public function hasRecaller()
    {
        return $this->cookie->exists('remember');
    }

    public function setUserFromCookie()
    {
        list($identifier, $token) = $this->recaller->splitCookieValue($this->cookie->get('remember'));


        if(!$user = $this->provider->getUserByRememberIdentifier($identifier)) {
            $this->cookie->clear('remember');
            return;
        }

        if(!$this->recaller->validateToken($token, $user->remember_token)) {

            $this->provider->clearUserRememberToken($user->id);
            $this->cookie->clear('remember');

            throw new \Exception();
        }

        $this->setUserSession($user);
    }
}