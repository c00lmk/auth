<?php


namespace App\Session;


class Flash
{

    private $messages;
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;

        $this->loadFlashMessagesIntoFlash();

        $this->clear();
    }

    protected function loadFlashMessagesIntoFlash()
    {
        $this->messages = $this->getAll();
    }

    protected function clear()
    {
        $this->session->clear('flash');
    }

    protected function getAll()
    {
        return $this->session->get('flash');
    }

    public function has($key)
    {
        return isset($this->messages[$key]);
    }

    public function get($key)
    {
        if ($this->has($key)){
            return $this->messages[$key];
        }

    }

    public function now($key, $value)
    {
        $this->session->set('flash', array_merge(
            $this->session->get('flash') ?? [], [$key => $value]
        ));
    }
}