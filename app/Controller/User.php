<?php
namespace App\blog\Controller;

use App\blog\Model\PostManager;
use App\blog\Model\UserManager;

class User extends Controller
{
    //page registration
    public function pageRegistration()
    {
        $this->twig->display('registration.html.twig');
    }
    //user registration
    public function userRegistration($lastname, $firstname, $email, $password)
    {
        $userManager = new UserManager();
        $userManager->userRegistration($lastname, $firstname, $email, $password);
        header('Location: index.php');
    }

    //page login
    public function pageLogin()
    {
        $this->twig->display('login.html.twig');
    }

    //user login
    public function userLogin($email, $password)
    {
        $postsManager = new PostManager();
        $posts = $postsManager->getPosts();
        
        $userManager = new UserManager();
        $newLogin = $userManager->userLogin($email, $password);
        if (password_verify($password, $newLogin['password']))
        {
            session_start();
            $_SESSION['firstname'] = $newLogin['firstname'];
            $_SESSION['lastname'] = $newLogin['lastname'];
            $_SESSION['email'] = $newLogin['email'];
            $_SESSION['role'] = $newLogin['role'];
            $this->twig->display('index.html.twig', [
                'posts' => $posts,
                'firstname' => $_SESSION['firstname'],
                'lastname' => $_SESSION['lastname'],
                'email' => $_SESSION['email'],
                'role' => $_SESSION['role']
            ]);
        }
        else
        {
            echo ('connexion refusé');
        }
    }
}