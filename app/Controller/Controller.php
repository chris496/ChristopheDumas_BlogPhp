<?php
namespace App\blog\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private $loader;
    protected $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(dirname(__DIR__).'\View\Templates');

        $this->twig = new Environment($this->loader);

        if(session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
    }

    public function isAdmin()
    {
        $superglobals = new SuperGlobals();
        $session = $superglobals->getSESSION();

        if($session['role'] === '1')
        {
            return
            [
                'id' => $session['id'],
                'firstname' => $session['firstname'],
                'lastname' => $session['lastname'],
                'email' => $session['email'],
                'role' => $session['role']
            ];
        }
    }
}