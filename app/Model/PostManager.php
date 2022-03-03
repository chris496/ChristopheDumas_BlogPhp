<?php

namespace App\blog\Model;

use DateTime;

class PostManager extends Model
{
    //display all posts
    public function getPosts()
    {
        $req = $this->db->query('SELECT id, title, chapo, update_date FROM post');
        $posts = $req->fetchAll();
        return $posts;
    }

    //display a selected post
    public function getPost($postId)
    {
        $req = $this->db->prepare('SELECT lastname, firstname, post.id, title, chapo, picture, description, post.added_date, post.update_date FROM user INNER JOIN post ON user.id = post.fk_user_id WHERE post.id = :id');
        $req->execute(array('id' => $postId));
        $post = $req->fetch();
        return $post;
    }

    //create a new post
    public function createPost($id, $title, $chapo, $description, $file)
    {
        //dd($id, $title, $chapo, $description, $file);
        $req = $this->db->prepare('INSERT INTO post(fk_user_id, title, chapo, description, picture, added_date) VALUES(:fk_user_id, :title, :chapo, :description, :picture, :create_at)');
        $newPost = $req->execute(array(
            'fk_user_id' => $id,
            'title' => $title,
            'chapo' => $chapo,
            'description' => $description,
            'picture' => $file,
            ':create_at' => date('Y-m-d H:i:s')
        ));
        return $newPost;
    }

    //update a post
    public function updatePost($id, $title, $chapo, $description, $file)
    {
        $req = $this->db->prepare('UPDATE post SET title = :title, chapo = :chapo, description = :description, picture = :picture, update_date = :update_date WHERE id = :id');
        $updatePost = $req->execute(array(
            'id' => $id,
            'title' => $title,
            'chapo' => $chapo,
            'description' => $description,
            'picture' => $file,
            'update_date' => date('Y-m-d H:i:s')
        ));
        return $updatePost;
    }
    //delete a post
    public function deletePost($id)
    {
        $req = $this->db->prepare('DELETE FROM post WHERE id = :id');
        $deletePost = $req->execute(array(
            'id' => $id,
        ));
        return $deletePost;
    }
    //delete a picture
    public function deletePicture($id)
    {
        $req = $this->db->prepare('UPDATE post SET picture = :picture WHERE id = :id');
        $deletePicture = $req->execute(array(
            'id' => $id,
            'picture' => ''
        ));
        return $deletePicture;
    }
}
