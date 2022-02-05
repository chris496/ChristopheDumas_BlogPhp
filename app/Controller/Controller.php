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
        if($_SESSION['role'] === '1')
        {
            return
            [
                'id' => $_SESSION['id'],
                'firstname' => $_SESSION['firstname'],
                'lastname' => $_SESSION['lastname'],
                'email' => $_SESSION['email'],
                'role' => $_SESSION['role']
            ];
        }
    }
}