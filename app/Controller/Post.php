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
        $superglobals = new SuperGlobals();
        $get = $superglobals->getGET();
        
        $user = $this->isAdmin();
        $postManager = new PostManager();
        $post = $postManager->getPost($get['id']);
        
        // display comments of post
        $commentsManager = new CommentManager();
        $comments = $commentsManager->getComments($get['id']);
        
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
        $superglobals = new SuperGlobals();
        $files =$superglobals->getFILES();
        
        if (isset($files['photo']) && $files['photo']['error'] == 0)
        {
            if ($files['photo']['size'] <= 4000000)
            {
                $fileInfo = pathinfo($files['photo']['name']);
                $extension = $fileInfo['extension'];
                $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($extension, $allowedExtensions))
                {
                    $uniqueName = uniqid('', true);
                    $file = $uniqueName.".".$extension;
                    move_uploaded_file($files['photo']['tmp_name'], 'uploads/' . basename($file));
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
        $superglobals = new SuperGlobals();
        $get = $superglobals->getGET();

        $user = $this->isAdmin();
        $postManager = new PostManager();
        $post = $postManager->getPost($get['id']);

        $this->twig->display('updateOnePost.html.twig', [
            'post' => $post,
            'user' => $user
        ]);
        return $post;
    }

    //update a post
    public function updatePost($id, $title, $chapo, $description)
    {
        $superglobals = new SuperGlobals();
        $files =$superglobals->getFILES();

        $postManager = new PostManager();
        $post = $postManager->getPost($id);

        if (isset($files['photo']) && $files['photo']['error'] == 0)
        {
            $fichier = './uploads/' .$post['picture'];
            if(file_exists($fichier)){unlink($fichier);}
            if ($files['photo']['size'] <= 4000000)
            {
                $fileInfo = pathinfo($files['photo']['name']);
                $extension = $fileInfo['extension'];
                $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($extension, $allowedExtensions))
                {
                    $uniqueName = uniqid('', true);
                    $file = $uniqueName.".".$extension;
                    move_uploaded_file($files['photo']['tmp_name'], 'uploads/' . basename($file));
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
        $superglobals = new SuperGlobals();
        $get = $superglobals->getGET();

        $postManager = new PostManager();
        $post = $postManager->getPost($get['id']);

        $fichier = './uploads/' .$post['picture'];
        if(file_exists($fichier)){unlink($fichier);}
        
        $postManager->deletePost($get['id']);
        header('Location: index.php?action=pageAdministration');
    }

    //delete a picture
    public function deletePicture()
    {
        $superglobals = new SuperGlobals();
        $get = $superglobals->getGET();

        $postManager = new PostManager();
        $post = $postManager->getPost($get['id']);

        $fichier = './uploads/' .$post['picture'];
        if(file_exists($fichier)){unlink($fichier);}
        
        $postManager->deletePicture($get['id']);
        header('Location: index.php?action=pageUpdatePost&id=' .$get['id']);
    }
}