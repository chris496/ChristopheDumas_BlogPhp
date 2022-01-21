<?php
use app\blog\Controller\Post;

require('./vendor/autoload.php');

if (isset($_GET['action'])){
    // Display all posts
    if ($_GET['action'] == 'allposts'){
        $allPosts = new Post();
        $allPosts->allPosts();
    }
}
else{
    $allPosts = new Post();
    $allPosts->allPosts();
}
