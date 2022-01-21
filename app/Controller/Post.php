<?php
namespace app\blog\Controller;

use app\blog\Model\PostManager;

class Post extends Controller{

    //display all posts
    public function allPosts()
    {
        $postsManager = new PostManager();
        $posts = $postsManager->getPosts();

        $this->twig->display('index.html.twig', [
            'posts' => $posts
        ]);
        return $posts;


    }
}