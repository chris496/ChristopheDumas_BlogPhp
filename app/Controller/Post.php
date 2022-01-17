<?php

use app\blog\Model\PostManager;

class Post{

    //display all posts
    public function allPosts()
    {
        $postsManager = new PostManager();
        $posts = $postsManager->getPosts();
        return $posts;
    }
}