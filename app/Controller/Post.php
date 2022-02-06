<?php
namespace App\blog\Controller;

use App\blog\Model\PostManager;
use App\blog\Model\CommentManager;

class Post extends Controller
{

    //display all posts
    public function allPosts()
    {
        $user = $this->isAdmin();
        $postsManager = new PostManager();
        $posts = $postsManager->getPosts();

        $this->twig->display('index.html.twig', [
            'posts' => $posts,
            'user' => $user
        ]);
        return $posts;
    }

     //display a selected post
    public function getOnePost()
    {
        $user = $this->isAdmin();
        $postManager = new PostManager();
        $post = $postManager->getPost($_GET['id']);
        
        // display comments of post
        $commentsManager = new CommentManager();
        $comments = $commentsManager->getComments($_GET['id']);

        $this->twig->display('onePost.html.twig', [
            'post' => $post,
            'comments' => $comments,
            'user' => $user
        ]);
        return $post;
    }

    //create a new post
    public function createPost($title, $chapo, $description)
    {
        $user = $this->isAdmin();
        $id = $user['id'];
        $postManager = new PostManager();
        $postManager->createPost($id, $title, $chapo, $description);
         header('Location: index.php');
    }

    //page update post
    public function pageUpdatePost()
    {
        $user = $this->isAdmin();
        $postManager = new PostManager();
        $post = $postManager->getPost($_GET['id']);

        $this->twig->display('updateOnePost.html.twig', [
            'post' => $post,
            'user' => $user
        ]);
        return $post;
    }

    //page update post
    public function updatePost($id, $title, $chapo, $description)
    {
        $postManager = new PostManager();
        $postManager->updatePost($id, $title, $chapo, $description);
        header('Location: index.php');
    }

    //delete a post
    public function deletePost()
    {
        $postManager = new PostManager();
        $postManager->deletePost($_GET['id']);
        header('Location: index.php?action=pageAdministration');
    }
}