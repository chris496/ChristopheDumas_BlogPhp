<?php

namespace App\blog\Controller;

use App\blog\SuperGlobals;
use App\blog\Entity\UserEntity;
use App\blog\Model\PostManager;
use App\blog\Model\UserManager;
use App\blog\Model\CommentManager;

class UserController extends Controller
{
    //page registration
    public function pageRegistration()
    {
        $url_slug = $this->UrlSlug();
        $this->twig->display('registration.html.twig', [
            'url' => $url_slug
        ]);
    }
    //user registration
    public function userRegistration($lastname, $firstname, $email, $password)
    {
        $userManager = new UserManager();
        $newLogin = $userManager->userLogin($email, $password);
        
        $url_slug = $this->UrlSlug();

        $lastname = htmlspecialchars($lastname);
        $firstname = htmlspecialchars($firstname);
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);

        if (!empty($lastname) && !empty($firstname) && !empty($email) && !empty($password)) {
            $pattern = '/^(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/';
            $patternEmail = '/.+\@.+\..+/';
            $patternPassword = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';
            if (preg_match($pattern, $lastname) && preg_match($pattern, $firstname) && preg_match($patternEmail, $email) && preg_match($patternPassword, $password) && (!$newLogin)) {
                $userEntity = new UserEntity();
                $user = $userEntity
                    ->setLastname($lastname)
                    ->setFirstname($firstname)
                    ->setEmail($email)
                    ->setPassword($password);
                $userManager = new UserManager();
                $userManager->userRegistration($user);
                return $this->twig->display('login.html.twig', [
                    'url' => $url_slug
                ]);
            } 
            return $this->twig->display('registration.html.twig', [
                'error' => true,
                'url' => $url_slug
            ]);
        }
        return $this->twig->display('registration.html.twig', [
            'vide' => true,
            'url' => $url_slug
        ]);
    }
    //validate user
    public function validUser($id)
    {
        $validUser = new UserManager();
        $validUser->validUser($id);
        return header('Location: ../pageAdministration');
    }
    //page login
    public function pageLogin()
    {
        $url_slug = $this->UrlSlug();
        $this->twig->display('login.html.twig', [
            'url' => $url_slug
        ]);
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

        $url_slug = $this->UrlSlug();

        if (!empty($email) && !empty($password)) {
            $patternEmail = '/.+\@.+\..+/';
            $patternPassword = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';
            if (preg_match($patternEmail, $email) && preg_match($patternPassword, $password) && (password_verify($password, $newLogin->getPassword()))) {
                if(session_status() !== PHP_SESSION_ACTIVE){
                    session_start();
                }
                $session['id'] = $newLogin->getId();
                $session['firstname'] = $newLogin->getFirstname();
                $session['lastname'] = $newLogin->getLastname();
                $session['email'] = $newLogin->getEmail();
                $session['role'] = $newLogin->getRole();

                $superglobals = new SuperGlobals();
                $session1 = $superglobals->setSESSION($session);

                return $this->twig->display('index.html.twig', [
                    'posts' => $posts,
                    'id' => $session1['id'],
                    'firstname' => $session1['firstname'],
                    'lastname' => $session1['lastname'],
                    'email' => $session1['email'],
                    'role' => $session1['role'],
                    'user' => $newLogin,
                    'url' => $url_slug
                ]);
            }
            return $this->twig->display('login.html.twig', [
                'error' => true,
                'url' => $url_slug
            ]);
        }
        return $this->twig->display('login.html.twig', [
            'vide' => true,
            'url' => $url_slug
        ]);
    }

    //user Logout
    public function userLogout()
    {
        $url_slug = $this->UrlSlug();
        $postsManager = new PostManager();
        $posts = $postsManager->getPosts();
        session_destroy();
        $this->twig->display('index.html.twig', [
            'posts' => $posts,
            'url' => $url_slug
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

        $url_slug = $this->UrlSlug();

        $user = $this->isAdmin();
        $this->twig->display('administration.html.twig', [
            'user' => $user,
            'allUsers' => $allUsers,
            'posts' => $posts,
            'allComments' => $allComments,
            'url' => $url_slug
        ]);
    }
}
