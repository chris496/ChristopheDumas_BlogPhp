<?php

use App\blog\Controller\Comment;
use App\blog\Controller\Post;
use App\blog\Controller\SuperGlobals;
use App\blog\Controller\User;

require('./vendor/autoload.php');

$superglobals = new SuperGlobals();
$post = $superglobals->getPOST();
$get =$superglobals->getGET();
$files =$superglobals->getFILES();

if (isset($get['action']))
{
    // Display all posts
    if ($get['action'] == 'allposts')
    {
        $allPosts = new Post();
        $allPosts->allPosts();
    }
    //display a selected post
    elseif ($get['action'] == 'getOnePost')
    {
        if (isset($get['id']) && $get['id'] > 0)
        {
            $getOnePost = new Post();
            $getOnePost->getOnePost();
        }
    }
    //create a new post
    elseif ($get['action'] == 'createPost')
    {
        if (!empty($post['title']) && !empty($post['chapo'] ) && !empty($post['description'] )){
            $createPost = new Post();
            $createPost->createPost($post['title'], $post['chapo'], $post['description'], $files['photo']);
        }
        else{
            echo 'tous les champs ne sont pas remplis !';
        }
    }
    //page update a post
    elseif ($get['action'] == 'pageUpdatePost')
    {
        if (isset($get['id']) && $get['id'] > 0)
        {
            $pageUpdatePost = new Post();
            $pageUpdatePost->pageUpdatePost();
        }
    }
    //update a post
    elseif ($get['action'] == 'updatePost'){
        if (isset($get['id']) && $get['id'] > 0) {
            if (!empty($post['title']) && !empty($post['chapo']) && !empty($post['description'])) 
            {
                $updatePost = new Post();
                $updatePost->updatePost($get['id'], $post['title'], $post['chapo'], $post['description'], $files['photo']);
            }
            else {
                echo 'Erreur : tous les champs ne sont pas remplis !';
            }
            
        }
        else {
            echo 'Erreur : aucun identifiant de billet envoyé';
        }
    }
    /*elseif ($_GET['action'] == 'createPost'){
        if (!empty($_POST['title']) && !empty($_POST['chapo'] ) && !empty($_POST['description'] )){
            $createPost = new Post();
            $createPost->createPost($_POST['title'], $_POST['chapo'], $_POST['description']);
        }
        else{
            echo 'tous les champs ne sont pas remplis !';
        }
    }*/
     //delete a picture
    elseif ($get['action'] == 'deletePicture'){
        if (isset($get['id']) && $get['id'] > 0) {
            $deletePost = new Post();
            $deletePost->deletePicture();
        }
        else {
            echo 'impossible de supprimer la photo !';
        }
    }
    //delete a post
    elseif ($get['action'] == 'deletePost'){
        if (isset($get['id']) && $get['id'] > 0) {
            $deletePost = new Post();
            $deletePost->deletePost();
        }
        else {
            echo 'impossible de supprimer le post !';
        }
    }
    //create a comment
    elseif ($get['action'] == 'createComment'){
        if (isset($get['id']) && $get['id'] > 0)
        {
            if (!empty($post['pseudo']) && !empty($post['email'] ) && !empty($post['description'] )){
                $createComment = new Comment();
                $createComment->createComment($get['id'], $post['pseudo'], $post['email'], $post['description']);
            }
            else{
                echo 'tous les champs ne sont pas remplis !';
            }
        }
        else {
            echo 'Erreur : aucun identifiant de post envoyé';
        }
    }
    //validate comment
    elseif ($get['action'] == 'validComment')
    {
        $validComment = new Comment();
        $validComment->validComment();
    }
    //delete a comment
    elseif ($get['action'] == 'deleteComment'){
        if (isset($get['id']) && $get['id'] > 0) {
            $deleteComment = new Comment();
            $deleteComment->deleteComment();
        }
        else {
            echo 'impossible de supprimer le commentaire !';
        }
    }
    //page registration
    elseif ($get['action'] == 'pageRegistration')
    {
        $user = new User();
        $user->pageRegistration();
    }
    //user registration
    elseif ($get['action'] == 'userRegistration')
    {
        if (!empty(!empty($post['lastname'] ) && $post['firstname']) && !empty($post['email'] ) && !empty($post['password'] )){
            $newUser = new User();
            $newUser->userRegistration($post['lastname'], $post['firstname'], $post['email'], $post['password']);
        }
        else{
            echo 'tous les champs ne sont pas remplis !';
        }
    }
    //validate user registration
    elseif ($get['action'] == 'validUser')
    {
        $validUser = new User();
        $validUser->validUser();
    }
    //page login
    elseif ($get['action'] == 'pageLogin')
    {
        $userLogin = new User();
        $userLogin->pageLogin();
    }
    //user login
    elseif ($get['action'] == 'userLogin')
    {
        if (!empty($post['email'] ) && !empty($post['password'] ))
        {
            $userLogin = new User();
            $userLogin->userLogin($post['email'], $post['password']);
        }
        else{
            echo 'connexion refusé';
        }
    }
    //user Logout
    elseif ($get['action'] == 'userLogout')
    {
        $userLogout = new User();
        $userLogout->userLogout();
    }
    //page Administration
    elseif ($get['action'] == 'pageAdministration')
    {
        $administration = new User();
        $administration->pageAdministration();
    }
}
else
{
    $allPosts = new Post();
    $allPosts->allPosts();
}
