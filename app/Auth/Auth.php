<?php


namespace App\Auth;


use App\Auth\Hashing\Hasher;
use App\Models\User;
use App\Session\SessionStore;
use Doctrine\ORM\EntityManager;

class Auth
{
    protected $db;

    protected $hasher;

    protected $session;

    protected $user;

    public function __construct(EntityManager $db, Hasher $hasher, SessionStore $session)
    {
        $this->db = $db;
        $this->hasher = $hasher;
        $this->session = $session;
    }

    public function attempt($username, $password)
    {
        $user = $this->getByUsername($username);

        if (!$user || !$this->hasValidCredentials($user, $password)) {
            return false;
        }

        if($this->needsRehash($user)){
            $this->rehashPassword($user, $password);
        }

        $this->setUserSession($user);
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

    protected function getById($user_id)
    {
        return $this->db->getRepository(User::class)->find($user_id);
    }

    protected function getByUsername($username)
    {
        return $this->db->getRepository(User::class)->findOneBy([
            'email' => $username
        ]);
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
        $user = $this->getById($this->session->get($this->key()));

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

    public function rehashPassword($user, $password)
    {
        // db update
        $this->db->getRepository(User::class)->find($user->id)->update([
            'password' => $this->hasher->create($password)
        ]);

        $this->db->flush();
    }

    public function logut()
    {
        $this->session->clear($this->key());
    }
}