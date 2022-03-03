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
        $newLogin = $userManager->userLogin($email, $password);

        $lastname = htmlspecialchars($lastname);
        $firstname = htmlspecialchars($firstname);
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);

        if (!empty($lastname) && !empty($firstname) && !empty($email) && !empty($password)) {
            $pattern = '/^(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/';
            $patternEmail = '/.+\@.+\..+/';
            $patternPassword = '/^(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/';
            if (preg_match($pattern, $lastname) && preg_match($pattern, $firstname) && preg_match($patternEmail, $email) && preg_match($patternPassword, $password) && ($email != $newLogin['email'])) {
                $userManager = new UserManager();
                $userManager->userRegistration($lastname, $firstname, $email, $password);
                return $this->twig->display('login.html.twig');
            } 
            return $this->twig->display('registration.html.twig', [
                'error' => true
            ]);
        }
        return $this->twig->display('registration.html.twig', [
            'vide' => true
        ]);
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

        $postsManager = new PostManager();
        $posts = $postsManager->getPosts();

        $userManager = new UserManager();
        $newLogin = $userManager->userLogin($email, $password);

        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);

        if (!empty($email) && !empty($password)) {
            $patternEmail = '/.+\@.+\..+/';
            $patternPassword = '/^(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/';
            if (preg_match($patternEmail, $email) && preg_match($patternPassword, $password) && (password_verify($password, $newLogin['password']))) {
                session_start();
                $session['id'] = $newLogin['id'];
                $session['firstname'] = $newLogin['firstname'];
                $session['lastname'] = $newLogin['lastname'];
                $session['email'] = $newLogin['email'];
                $session['role'] = $newLogin['role'];

                $superglobals = new SuperGlobals();
                $session1 = $superglobals->setSESSION($session);

                $this->twig->display('index.html.twig', [
                    'posts' => $posts,
                    'id' => $session1['id'],
                    'firstname' => $session1['firstname'],
                    'lastname' => $session1['lastname'],
                    'email' => $session1['email'],
                    'role' => $session1['role'],
                    'user' => $newLogin
                ]);
            }
            return $this->twig->display('login.html.twig', [
                'error' => true
            ]);
        }
        return $this->twig->display('login.html.twig', [
            'vide' => true
        ]);
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
