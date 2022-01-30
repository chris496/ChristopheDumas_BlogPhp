<?php

namespace App\blog\Model;

class CommentManager extends Model
{
    //create a new comment
    public function postComment($postId, $pseudo, $email, $description)
    {
        $req = $this->db->prepare('INSERT INTO comment(fk_post_id, pseudo, email, description, added_date) VALUES (:fk_post_id, :pseudo, :email, :description, :added_date)');
        $newComment = $req->execute(array(
            'fk_post_id' => $postId,
            'pseudo' => $pseudo,
            'email' => $email,
            'description' => $description,
            'added_date' => date('Y-m-d H:i:s')
        ));
        return $newComment;
    }

    //display comments for one post
    public function getComments($postId)
    {
        $req = $this->db->prepare('SELECT * FROM comment WHERE fk_post_id = :id');
        $req->execute(array('id' => $postId));
        $comments = $req->fetchAll();
        return $comments;
    }
}