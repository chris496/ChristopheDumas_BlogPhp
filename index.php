<?php
use app\blog\Controller\Post;

require('./vendor/autoload.php');

if (isset($_GET['action'])){
    // Display all posts
    if ($_GET['action'] == 'allposts'){
        $allPosts = new Post();
        $allPosts->allPosts();
    }
    //display a selected post
    elseif ($_GET['action'] == 'getOnePost'){
        if (isset($_GET['id']) && $_GET['id'] > 0){
            $getOnePost = new Post();
            $getOnePost->getOnePost();
        }
    }
}
else{
    $allPosts = new Post();
    $allPosts->allPosts();
}
