<?php

namespace App\blog\Controller;

use Cocur\Slugify\Slugify;
use App\blog\Model\PostManager;
use App\blog\Model\UserManager;
use App\blog\Model\CommentManager;

class Post extends Controller
{
    //display all posts
    public function allPosts()
    {
        $user = $this->isAdmin();
        $url_slug = $this->UrlSlug();
        $postsManager = new PostManager();
        $posts = $postsManager->getPosts();
        return $this->twig->display('index.html.twig', [
            'posts' => $posts,
            'user' => $user,
            'url' => $url_slug
        ]);
    }

    //display a selected post
    public function getOnePost($id)
    {
        $user = $this->isAdmin();
        $url_slug = $this->UrlSlug();
        $postManager = new PostManager();
        $post = $postManager->getPost($id);

        // display comments of post
        $commentsManager = new CommentManager();
        $comments = $commentsManager->getComments($id);

        return $this->twig->display('onePost.html.twig', [
            'post' => $post,
            'comments' => $comments,
            'user' => $user,
            'url' => $url_slug
        ]);
    }

    //create a new post
    public function createPost($title, $chapo, $description)
    {
        $slugify = new Slugify();
        $slug = $slugify->slugify($title);

        $superglobals = new SuperGlobals();
        $files = $superglobals->getFILES();

        $user = $this->isAdmin();
        $url_slug = $this->UrlSlug();
        $postManager = new PostManager();
        $posts = $postManager->getPosts();

        $commentsManager = new CommentManager();
        $allComments = $commentsManager->getAllComments();

        $UsersManager = new UserManager();
        $allUsers = $UsersManager->getAllUsers();
        
        $title = htmlspecialchars($title);
        $chapo = htmlspecialchars($chapo);
        $description = htmlspecialchars($description);

        if (isset($files['photo']) && $files['photo']['error'] == 0) {
            if ($files['photo']['size'] <= 4000000) {
                $fileInfo = pathinfo($files['photo']['name']);
                $extension = $fileInfo['extension'];
                $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($extension, $allowedExtensions)) {
                    $uniqueName = uniqid('', true);
                    $file = $uniqueName . "." . $extension;
                    move_uploaded_file($files['photo']['tmp_name'], 'uploads/' . basename($file));
                }
            }
        };

        if (!empty($title) && !empty($chapo) && !empty($description)) {
            $user = $this->isAdmin();
            $id = $user['id'];
            $file = isset($file)?$file:'';
            $postManager->createPost($id, $title, $chapo, $description, $file, $slug);
            $posts = $postManager->getPosts();
            
            return $this->twig->display('index.html.twig', [
                'posts' => $posts,
                'user' => $user,
                'url' => $url_slug
            ]);
        } 
        return $this->twig->display('administration.html.twig', [
            'vide' => true,
            'user' => $user,
            'allUsers' => $allUsers,
            'posts' => $posts,
            'allComments' => $allComments,
            'url' => $url_slug
        ]);
    }

    //page update post
    public function pageUpdatePost($id)
    {
        $user = $this->isAdmin();
        $url_slug = $this->UrlSlug();
        $postManager = new PostManager();
        $post = $postManager->getPost($id);

        return $this->twig->display('updateOnePost.html.twig', [
            'post' => $post,
            'user' => $user,
            'url' => $url_slug
        ]);
    }

    //update a post
    public function updatePost($id, $title, $chapo, $description)
    {
        $superglobals = new SuperGlobals();
        $files = $superglobals->getFILES();
        
        $title = htmlspecialchars($title);
        $chapo = htmlspecialchars($chapo);
        $description = htmlspecialchars($description);

        $postManager = new PostManager();
        $post = $postManager->getPost($id);

        $url_slug = $this->UrlSlug();

        if (isset($files['photo']) && $files['photo']['error'] == 0) {
            $fichier = '/ChristopheDumas_BlogPhp/uploads/' . $post['picture'];
            if (file_exists($fichier)) {
                unlink($fichier);
            }
            if ($files['photo']['size'] <= 4000000) {
                $fileInfo = pathinfo($files['photo']['name']);
                $extension = $fileInfo['extension'];
                $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($extension, $allowedExtensions)) {
                    $uniqueName = uniqid('', true);
                    $file = $uniqueName . "." . $extension;
                    move_uploaded_file($files['photo']['tmp_name'], 'uploads/' . basename($file));
                }
            }
        };

        if (!empty($title) && !empty($chapo) && !empty($description)) {
            $user = $this->isAdmin();
            $file = isset($file)?$file:'';
            $postManager->updatePost($id, $title, $chapo, $description, $file);
            $posts = $postManager->getPosts();
            
            return $this->twig->display('index.html.twig', [
                'posts' => $posts,
                'user' => $user,
                'url' => $url_slug
            ]);
        }
        return $this->twig->display('updateOnePost.html.twig', [
            'vide' => true,
            'url' => $url_slug
        ]);
    }

    //delete a post
    public function deletePost($id)
    {
        $postManager = new PostManager();
        $post = $postManager->getPost($id);

        $fichier = '/ChristopheDumas_BlogPhp/uploads/' . $post['picture'];
        if (file_exists($fichier)) {
            unlink($fichier);
        }

        $postManager->deletePost($id);
        return header('Location: ../pageAdministration');
        /*return $this->twig->display('administration.html.twig', [
            'user' => $user,
            'allUsers' => $allUsers,
            'posts' => $posts,
            'allComments' => $allComments
        ]);*/
    }

    //delete a picture
    public function deletePicture($id)
    {
        $postManager = new PostManager();
        $post = $postManager->getPost($id);

        $fichier = './uploads/' . $post['picture'];
        if (file_exists($fichier)) {
            unlink($fichier);
        }

        $postManager->deletePicture($id);
        return header('Location: pageUpdatePost/' . $id);
    }
}
