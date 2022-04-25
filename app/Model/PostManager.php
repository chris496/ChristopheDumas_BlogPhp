<?php

namespace App\blog\Model;

use PDO;
use DateTime;
use App\blog\Entity\PostEntity;

class PostManager
{
    private $db;
    
    //display all posts
    public function getPosts()
    {
        $this->db = Model::getPdo();
        $req = $this->db->query('SELECT id, title, chapo, slug, added_date, update_date FROM post ORDER BY added_date ASC');
        return $req->fetchAll(PDO::FETCH_CLASS, PostEntity::class);
        
    }

    //display a selected post
    public function getPost($postId)
    {
        $this->db = Model::getPdo();
        $req = $this->db->prepare('SELECT lastname, firstname, post.id, title, chapo, picture, slug, description, post.added_date, post.update_date FROM user INNER JOIN post ON user.id = post.fk_user_id WHERE post.id = :id');
        $req->execute(array('id' => $postId));
        return $req->fetchObject(PostEntity::class);
    }

    //create a new post
    public function createPost($user, $post)
    {
        $id = $user->getId();
        $title = $post->getTitle();
        $chapo = $post->getChapo();
        $description = $post->getDescription();
        $slug = $post->getSlug();
        $file = $post->getPicture();

        $this->db = Model::getPdo();
        $req = $this->db->prepare('INSERT INTO post(fk_user_id, title, chapo, description, picture, slug, added_date) VALUES(:fk_user_id, :title, :chapo, :description, :picture, :slug, :create_at)');
        return $req->execute(array(
            'fk_user_id' => $id,
            'title' => $title,
            'chapo' => $chapo,
            'description' => $description,
            'picture' => $file,
            'slug' => $slug,
            ':create_at' => date('Y-m-d H:i:s')
        ));
    }

    //update a post
    public function updatePost($id, $post)
    {
        $title = $post->getTitle();
        $chapo = $post->getChapo();
        $description = $post->getDescription();
        $file = $post->getPicture();

        $this->db = Model::getPdo();
        $req = $this->db->prepare('UPDATE post SET title = :title, chapo = :chapo, description = :description, picture = :picture, update_date = :update_date WHERE id = :id');
        return $req->execute(array(
            'id' => $id,
            'title' => $title,
            'chapo' => $chapo,
            'description' => $description,
            'picture' => $file,
            'update_date' => date('Y-m-d H:i:s')
        ));
    }
    //delete a post
    public function deletePost($id)
    {
        $this->db = Model::getPdo();
        $req = $this->db->prepare('DELETE FROM post WHERE id = :id');
        return $req->execute(array(
            'id' => $id,
        ));
    }
    //delete a picture
    public function deletePicture($id)
    {
        $this->db = Model::getPdo();
        $req = $this->db->prepare('UPDATE post SET picture = :picture WHERE id = :id');
        return $req->execute(array(
            'id' => $id,
            'picture' => ''
        ));
    }
}
