<?php

namespace App\blog;

use App\blog\Controller\PostController;
use App\blog\Controller\UserController;
use App\blog\Controller\CommentController;
use App\blog\Controller\SendMailController;

class Router
{
    
    public function router()
    {
        $superglobals = new SuperGlobals();
        $server = $superglobals->getSERVER();
        $post = $superglobals->getPOST();
        $files = $superglobals->getFILES();
        $urlArray = explode("/", $server["REQUEST_URI"]);
        if (count($urlArray) > 3) {
            $id = $urlArray[count($urlArray) - 1];
            $path = $urlArray[count($urlArray) - 2];
        }else {
            $path = $urlArray[count($urlArray) - 1];
        }
        if ($path == "" || $path == "accueil") {
            $allPosts = new PostController();
            $allPosts->allPosts();
        }
        switch ($path) {
                //display a selected post
            case 'post':
                $getOnePost = new PostController();
                $getOnePost->getOnePost($id);
                break;
                //page update a post
            case 'pageUpdatePost':
                $pageUpdatePost = new PostController();
                $pageUpdatePost->pageUpdatePost($id);
                break;
                //delete a picture
            case 'deletePicture':
                $deletePost = new PostController();
                $deletePost->deletePicture($id);
                break;
                //delete a post
            case 'deletePost':
                $deletePost = new PostController();
                $deletePost->deletePost($id);
                break;
                //validate comment
            case 'validComment':
                $validComment = new CommentController();
                $validComment->validComment($id);
                break;
                //delete a comment
            case 'deleteComment':
                $deleteComment = new CommentController();
                $deleteComment->deleteComment($id);
                break;
                //page registration
            case 'pageRegistration':
                $user = new UserController();
                $user->pageRegistration();
                break;
                //validate user registration
            case 'validUser':
                $validUser = new UserController();
                $validUser->validUser($id);
                break;
                //page login
            case 'pageLogin':
                $userLogin = new UserController();
                $userLogin->pageLogin();
                break;
                //user Logout
            case 'userLogout':
                $userLogout = new UserController();
                $userLogout->userLogout();
                break;
                //page Administration
            case 'pageAdministration':
                $administration = new UserController();
                $administration->pageAdministration();
                break;
                //user login
            case 'userLogin':
                $userLogin = new UserController();
                $userLogin->userLogin($post['email'], $post['password']);
                break;
                //create a new post
            case 'createPost':
                $createPost = new PostController();
                $createPost->createPost($post['title'], $post['chapo'], $post['description'], $files['photo']);
                break;
                //update a post
            case 'updatePost':
                $updatePost = new PostController();
                $updatePost->updatePost($id, $post['title'], $post['chapo'], $post['description'], $files['photo']);
                break;
                //create a comment
            case 'createComment':
                $createComment = new CommentController();
                $createComment->createComment($id, $post['pseudo'], $post['email'], $post['description']);
                break;
                //user registration
            case 'userRegistration':
                $newUser = new UserController();
                $newUser->userRegistration($post['lastname'], $post['firstname'], $post['email'], $post['password']);
                break;
                //send mail
            case 'sendMail':
                $sendMail = new SendMailController();
                $sendMail->sendMail($post['lastname'], $post['firstname'], $post['email'], $post['description']);
                break;
        }
    }
}
