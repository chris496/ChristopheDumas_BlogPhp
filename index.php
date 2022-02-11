<?php

use App\blog\Controller\Comment;
use App\blog\Controller\Post;
use App\blog\Controller\User;

require('./vendor/autoload.php');

if (isset($_GET['action']))
{
    // Display all posts
    if ($_GET['action'] == 'allposts')
    {
        $allPosts = new Post();
        $allPosts->allPosts();
    }
    //display a selected post
    elseif ($_GET['action'] == 'getOnePost')
    {
        if (isset($_GET['id']) && $_GET['id'] > 0)
        {
            $getOnePost = new Post();
            $getOnePost->getOnePost();
        }
    }
    //create a new post
    elseif ($_GET['action'] == 'createPost'){
        //dd($_POST['title'], $_POST['chapo'], $_POST['description'], $_FILES['photo']);
        if (!empty($_POST['title']) && !empty($_POST['chapo'] ) && !empty($_POST['description'] )){
            $createPost = new Post();
            $createPost->createPost($_POST['title'], $_POST['chapo'], $_POST['description'], $_FILES['photo']);
        }
        else{
            echo 'tous les champs ne sont pas remplis !';
        }
    }
    //page update a post
    elseif ($_GET['action'] == 'pageUpdatePost')
    {
        if (isset($_GET['id']) && $_GET['id'] > 0)
        {
            $pageUpdatePost = new Post();
            $pageUpdatePost->pageUpdatePost();
        }
    }
    //update a post
    elseif ($_GET['action'] == 'updatePost'){
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            if (!empty($_POST['title']) && !empty($_POST['chapo']) && !empty($_POST['description'])) 
            {
                $updatePost = new Post();
                $updatePost->updatePost($_GET['id'], $_POST['title'], $_POST['chapo'], $_POST['description'], $_FILES['photo']);
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
    elseif ($_GET['action'] == 'deletePicture'){
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $deletePost = new Post();
            $deletePost->deletePicture();
        }
        else {
            echo 'impossible de supprimer la photo !';
        }
    }
    //delete a post
    elseif ($_GET['action'] == 'deletePost'){
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $deletePost = new Post();
            $deletePost->deletePost();
        }
        else {
            echo 'impossible de supprimer le post !';
        }
    }
    //create a comment
    elseif ($_GET['action'] == 'createComment'){
        if (isset($_GET['id']) && $_GET['id'] > 0)
        {
            if (!empty($_POST['pseudo']) && !empty($_POST['email'] ) && !empty($_POST['description'] )){
                $createComment = new Comment();
                $createComment->createComment($_GET['id'], $_POST['pseudo'], $_POST['email'], $_POST['description']);
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
    elseif ($_GET['action'] == 'validComment')
    {
        $validComment = new Comment();
        $validComment->validComment();
    }
    //delete a comment
    elseif ($_GET['action'] == 'deleteComment'){
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $deleteComment = new Comment();
            $deleteComment->deleteComment();
        }
        else {
            echo 'impossible de supprimer le commentaire !';
        }
    }
    //page registration
    elseif ($_GET['action'] == 'pageRegistration')
    {
        $user = new User();
        $user->pageRegistration();
    }
    //user registration
    elseif ($_GET['action'] == 'userRegistration')
    {
        if (!empty(!empty($_POST['lastname'] ) && $_POST['firstname']) && !empty($_POST['email'] ) && !empty($_POST['password'] )){
            $newUser = new User();
            $newUser->userRegistration($_POST['lastname'], $_POST['firstname'], $_POST['email'], $_POST['password']);
        }
        else{
            echo 'tous les champs ne sont pas remplis !';
        }
    }
    //validate user registration
    elseif ($_GET['action'] == 'validUser')
    {
        $validUser = new User();
        $validUser->validUser();
    }
    //page login
    elseif ($_GET['action'] == 'pageLogin')
    {
        $userLogin = new User();
        $userLogin->pageLogin();
    }
    //user login
    elseif ($_GET['action'] == 'userLogin')
    {
        if (!empty($_POST['email'] ) && !empty($_POST['password'] ))
        {
            $userLogin = new User();
            $userLogin->userLogin($_POST['email'], $_POST['password']);
        }
        else{
            echo 'connexion refusé';
        }
    }
    //user Logout
    elseif ($_GET['action'] == 'userLogout')
    {
        $userLogout = new User();
        $userLogout->userLogout();
    }
    //page Administration
    elseif ($_GET['action'] == 'pageAdministration')
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
