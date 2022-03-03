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
        $get = $superglobals->getGET();
        $files = $superglobals->getFILES();

        if (isset($get['action'])) {
            // Display all posts
            if ($get['action'] == 'allposts') {
                $allPosts = new Post();
                $allPosts->allPosts();
            }
            //display a selected post
            elseif ($get['action'] == 'getOnePost') {
                if (isset($get['id']) && $get['id'] > 0) {
                    $getOnePost = new Post();
                    $getOnePost->getOnePost();
                }
            }
            //create a new post
            elseif ($get['action'] == 'createPost') {
                $createPost = new Post();
                $createPost->createPost($post['title'], $post['chapo'], $post['description'], $files['photo']);
            }
            //page update a post
            elseif ($get['action'] == 'pageUpdatePost') {
                if (isset($get['id']) && $get['id'] > 0) {
                    $pageUpdatePost = new Post();
                    $pageUpdatePost->pageUpdatePost();
                }
            }
            //update a post
            elseif ($get['action'] == 'updatePost') {
                if ($get['id'] > 0) {
                    $updatePost = new Post();
                    $updatePost->updatePost($get['id'], $post['title'], $post['chapo'], $post['description'], $files['photo']);
                }
            }
            //delete a picture
            elseif ($get['action'] == 'deletePicture') {
                if (isset($get['id']) && $get['id'] > 0) {
                    $deletePost = new Post();
                    $deletePost->deletePicture();
                }
            }
            //delete a post
            elseif ($get['action'] == 'deletePost') {
                if (isset($get['id']) && $get['id'] > 0) {
                    $deletePost = new Post();
                    $deletePost->deletePost();
                }
            }
            //create a comment
            elseif ($get['action'] == 'createComment') {
                if ($get['id'] > 0) {
                    $createComment = new Comment();
                    $createComment->createComment($get['id'], $post['pseudo'], $post['email'], $post['description']);
                }
            }
            //validate comment
            elseif ($get['action'] == 'validComment') {
                $validComment = new Comment();
                $validComment->validComment();
            }
            //delete a comment
            elseif ($get['action'] == 'deleteComment') {
                if ($get['id'] > 0) {
                    $deleteComment = new Comment();
                    $deleteComment->deleteComment();
                }
            }
            //page registration
            elseif ($get['action'] == 'pageRegistration') {
                $user = new User();
                $user->pageRegistration();
            }
            //user registration
            elseif ($get['action'] == 'userRegistration') {
                $newUser = new User();
                $newUser->userRegistration($post['lastname'], $post['firstname'], $post['email'], $post['password']);
            }
            //validate user registration
            elseif ($get['action'] == 'validUser') {
                $validUser = new User();
                $validUser->validUser();
            }
            //page login
            elseif ($get['action'] == 'pageLogin') {
                $userLogin = new User();
                $userLogin->pageLogin();
            }
            //user login
            elseif ($get['action'] == 'userLogin') {
                $userLogin = new User();
                $userLogin->userLogin($post['email'], $post['password']);
            }
            //user Logout
            elseif ($get['action'] == 'userLogout') {
                $userLogout = new User();
                $userLogout->userLogout();
            }
            //page Administration
            elseif ($get['action'] == 'pageAdministration') {
                $administration = new User();
                $administration->pageAdministration();
            }
            //send mail
            elseif ($get['action'] == 'sendMail') {
                $sendMail = new SendMail();
                $sendMail->sendMail($post['lastname'], $post['firstname'], $post['email'], $post['description']);
            }
        } else {
            $allPosts = new Post();
            $allPosts->allPosts();
        }
    }
}