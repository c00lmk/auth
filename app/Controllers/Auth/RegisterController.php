<?php


namespace App\Controllers\Auth;


use App\Auth\Auth;
use App\Auth\Hashing\Hasher;
use App\Controllers\Controller;
use App\Models\User;
use App\Views\View;
use Doctrine\ORM\EntityManager;
use League\Route\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class RegisterController extends Controller
{
    protected $view;
    protected $auth;
    private $hasher;
    private $db;
    private $router;

    public function __construct(View $view, Auth $auth, Hasher $hasher, EntityManager $db, Router $router)
    {
        $this->view = $view;
        $this->auth = $auth;
        $this->hasher = $hasher;
        $this->db = $db;
        $this->router = $router;

    }

    /**
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {

        $response = new Response();
        return $this->view->render($response, 'auth/register.twig');

    }

    public function register(ServerRequestInterface $request): ResponseInterface
    {
        $data = $this->validateRegistration($request);

        $user = $this->createUser($data);

        if(!$this->auth->attempt($data['email'], $data['password'])) {
            return redirect($this->router->getNamedRoute('home')->getPath());
        }

        $response = redirect($this->router->getNamedRoute('home')->getPath());

        return $response;
    }

    private function createUser($data)
    {
        $user = new User();

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $this->hasher->create($data['password'])
        ]);

        $this->db->persist($user);
        $this->db->flush();

        return $user;
    }


    private function validateRegistration(ServerRequestInterface $request)
    {
        return $this->validate($request, [
            'email' => ['required', 'email', ['exists', User::class]],
            'name' => ['required'],
            'password' => ['required'],
            'password_confirmation' => ['required', ['equals', 'password']]
        ]);
    }
}