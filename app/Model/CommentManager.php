<?php

namespace App\blog\Model;

use PDO;
use App\blog\Entity\CommentEntity;

class CommentManager extends Model
{
    private $db;
    //create a new comment
    public function postComment($postId, $comment)
    {
        $postId = $postId->getId();
        $pseudo = $comment->getPseudo();
        $email = $comment->getEmail();
        $description = $comment->getDescription();

        $this->db = Model::getPdo();
        $req = $this->db->prepare('INSERT INTO comment(fk_post_id, pseudo, email, description, added_date) VALUES (:fk_post_id, :pseudo, :email, :description, :added_date)');
        return $req->execute(array(
            'fk_post_id' => $postId,
            'pseudo' => $pseudo,
            'email' => $email,
            'description' => $description,
            'added_date' => date('Y-m-d H:i:s')
        ));
    }

    //valid comment
    public function validComment($id)
    {
        $this->db = Model::getPdo();
        $req = $this->db->prepare('UPDATE comment SET isValid = :isValid WHERE id = :id');
        $req->execute(array(
            'isValid' => '1',
            'id' => $id
        ));
        return $req->fetchObject(CommentEntity::class);
    }
    //display all comments
    public function getAllComments()
    {
        $this->db = Model::getPdo();
        $req = $this->db->query('SELECT * FROM comment ORDER BY added_date ASC');
        return $req->fetchAll(PDO::FETCH_CLASS, CommentEntity::class);
    }

    //display comments for one post
    public function getComments($postId)
    {
        $this->db = Model::getPdo();
        $req = $this->db->prepare('SELECT * FROM comment WHERE fk_post_id = :id');
        $req->execute(array('id' => $postId));
        return $req->fetchAll(PDO::FETCH_CLASS, CommentEntity::class);
    }

    //delete a comment
    public function deleteComment($id)
    {
        $this->db = Model::getPdo();
        $req = $this->db->prepare('DELETE FROM comment WHERE id = :id');
        return $req->execute(array(
            'id' => $id,
        ));
    }
}
