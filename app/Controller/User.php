<?php
namespace App\blog\Controller;

use App\blog\Model\PostManager;
use App\blog\Model\UserManager;
use App\blog\Model\CommentManager;

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
    //validate user
    public function validUser()
    {
        $superglobals = new SuperGlobals();
        $get = $superglobals->getGET();

        $validUser = new UserManager();
        $valid = $validUser->validUser($get['id']);
        $this->twig->display('administration.html.twig', [
            'userValid' => $valid,
        ]);
    }
    //page login
    public function pageLogin()
    {
        $this->twig->display('login.html.twig');
    }

    //user login
    public function userLogin($email, $password)
    {
        $superglobals = new SuperGlobals();
        $session = $superglobals->getSESSION();

        $postsManager = new PostManager();
        $posts = $postsManager->getPosts();
        
        $userManager = new UserManager();
        $newLogin = $userManager->userLogin($email, $password);
        if (password_verify($password, $newLogin['password']))
        {
            session_start();
            $session['id'] = $newLogin['id'];
            $session['firstname'] = $newLogin['firstname'];
            $session['lastname'] = $newLogin['lastname'];
            $session['email'] = $newLogin['email'];
            $session['role'] = $newLogin['role'];

            $this->twig->display('index.html.twig', [
                'posts' => $posts,
                'id' => $session['id'],
                'firstname' => $session['firstname'],
                'lastname' => $session['lastname'],
                'email' => $session['email'],
                'role' => $session['role'],
                'user' => $newLogin
            ]);
        }
        else
        {
            echo ('connexion refusé');
        }
    }

    //user Logout
    public function userLogout()
    {
        $postsManager = new PostManager();
        $posts = $postsManager->getPosts();
        session_destroy();
        $this->twig->display('index.html.twig', [
            'posts' => $posts
        ]);
    }

    //page administration
    public function pageAdministration()
    {
        $postsManager = new PostManager();
        $posts = $postsManager->getPosts();

        $commentsManager = new CommentManager();
        $allComments = $commentsManager->getAllComments();

        $UsersManager = new UserManager();
        $allUsers = $UsersManager->getAllUsers();
       
        $user = $this->isAdmin();
        $this->twig->display('administration.html.twig', [
            'user' => $user,
            'allUsers' => $allUsers,
            'posts' => $posts,
            'allComments' => $allComments
        ]);
    }

}