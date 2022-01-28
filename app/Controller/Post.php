<?php
namespace App\blog\Controller;

use App\blog\Model\PostManager;

class Post extends Controller
{

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

     //display a selected post
     public function getOnePost()
    {
        $postManager = new PostManager();
        $post = $postManager->getPost($_GET['id']);
        $this->twig->display('onePost.html.twig', [
            'post' => $post
        ]);
        return $post;
    }
}