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
        
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0)
        {
            if ($_FILES['photo']['size'] <= 4000000)
            {
                $fileInfo = pathinfo($_FILES['photo']['name']);
                $extension = $fileInfo['extension'];
                $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($extension, $allowedExtensions))
                {
                    $uniqueName = uniqid('', true);
                    $file = $uniqueName.".".$extension;
                    move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . basename($file));
                    echo "L'envoi a bien été effectué !";
                }
            }
        };

        $user = $this->isAdmin();
        $id = $user['id'];
        $postManager = new PostManager();
        $postManager->createPost($id, $title, $chapo, $description, $file);
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

    //update a post
    public function updatePost($id, $title, $chapo, $description)
    {
        $postManager = new PostManager();
        $post = $postManager->getPost($id);

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0)
        {
            $fichier = './uploads/' .$post['picture'];
            if(file_exists($fichier)){unlink($fichier);}
            if ($_FILES['photo']['size'] <= 4000000)
            {
                $fileInfo = pathinfo($_FILES['photo']['name']);
                $extension = $fileInfo['extension'];
                $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($extension, $allowedExtensions))
                {
                    $uniqueName = uniqid('', true);
                    $file = $uniqueName.".".$extension;
                    move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . basename($file));
                    echo "L'envoi a bien été effectué !";
                }
            }
        };
        
        $postManager->updatePost($id, $title, $chapo, $description, $file);
        header('Location: index.php');
    }

    //delete a post
    public function deletePost()
    {
        $postManager = new PostManager();
        $post = $postManager->getPost($_GET['id']);

        $fichier = './uploads/' .$post['picture'];
        if(file_exists($fichier)){unlink($fichier);}
        
        $postManager->deletePost($_GET['id']);
        header('Location: index.php?action=pageAdministration');
    }

    //delete a picture
    public function deletePicture()
    {
        $postManager = new PostManager();
        $post = $postManager->getPost($_GET['id']);

        $fichier = './uploads/' .$post['picture'];
        if(file_exists($fichier)){unlink($fichier);}
        
        $postManager->deletePicture($_GET['id']);
        header('Location: index.php?action=pageUpdatePost&id=' .$_GET['id']);
    }
}