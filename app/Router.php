<?php

namespace App\blog;

use App\blog\Controller\Post;
use App\blog\Controller\User;
use App\blog\Controller\Comment;
use App\blog\Controller\SendMail;
use App\blog\Controller\SuperGlobals;

class Router
{
    public function router()
    {
        $superglobals = new SuperGlobals();
        $post = $superglobals->getPOST();
        $files = $superglobals->getFILES();
        $urlArray = explode("/", $_SERVER["REQUEST_URI"]);
        if (count($urlArray) > 3) {
            $id = $urlArray[count($urlArray) - 1];
            $path = $urlArray[count($urlArray) - 2];
        } else {
            $path = $urlArray[count($urlArray) - 1];
        }
        if ($path == "" || $path == "accueil") {
            $allPosts = new Post();
            $allPosts->allPosts();
        }
        switch ($path) {
                //display a selected post
            case 'post':
                $getOnePost = new Post();
                $getOnePost->getOnePost($id);
                break;
                //page update a post
            case 'pageUpdatePost':
                $pageUpdatePost = new Post();
                $pageUpdatePost->pageUpdatePost($id);
                break;
                //delete a picture
            case 'deletePicture':
                $deletePost = new Post();
                $deletePost->deletePicture($id);
                break;
                //delete a post
            case 'deletePost':
                $deletePost = new Post();
                $deletePost->deletePost($id);
                break;
                //validate comment
            case 'validComment':
                $validComment = new Comment();
                $validComment->validComment($id);
                break;
                //delete a comment
            case 'deleteComment':
                $deleteComment = new Comment();
                $deleteComment->deleteComment($id);
                break;
                //page registration
            case 'pageRegistration':
                $user = new User();
                $user->pageRegistration();
                break;
                //validate user registration
            case 'validUser':
                $validUser = new User();
                $validUser->validUser($id);
                break;
                //page login
            case 'pageLogin':
                $userLogin = new User();
                $userLogin->pageLogin();
                break;
                //user Logout
            case 'userLogout':
                $userLogout = new User();
                $userLogout->userLogout();
                break;
                //page Administration
            case 'pageAdministration':
                $administration = new User();
                $administration->pageAdministration();
                break;
                //user login
            case 'userLogin':
                $userLogin = new User();
                $userLogin->userLogin($post['email'], $post['password']);
                break;
                //create a new post
            case 'createPost':
                $createPost = new Post();
                $createPost->createPost($post['title'], $post['chapo'], $post['description'], $files['photo']);
                break;
                //update a post
            case 'updatePost':
                $updatePost = new Post();
                $updatePost->updatePost($id, $post['title'], $post['chapo'], $post['description'], $files['photo']);
                break;
                //create a comment
            case 'createComment':
                $createComment = new Comment();
                $createComment->createComment($id, $post['pseudo'], $post['email'], $post['description']);
                break;
                //user registration
            case 'userRegistration':
                $newUser = new User();
                $newUser->userRegistration($post['lastname'], $post['firstname'], $post['email'], $post['password']);
                break;
                //send mail
            case 'createComment':
                $sendMail = new SendMail();
                $sendMail->sendMail($post['lastname'], $post['firstname'], $post['email'], $post['description']);
                break;
        }
    }
}
