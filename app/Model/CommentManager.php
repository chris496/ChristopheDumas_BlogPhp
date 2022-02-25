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

    //valid comment
    public function validComment($id)
    {
        $req = $this->db->prepare('UPDATE comment SET isValid = :isValid WHERE id = :id');
        $validComment = $req->execute(array(
            'isValid' => '1',
            'id' => $id
        ));
        return $validComment;
    }
    //display all comments
    public function getAllComments()
    {
        $req = $this->db->query('SELECT * FROM comment');
        $allComments = $req->fetchAll();
        return $allComments;
    }

    //display comments for one post
    public function getComments($postId)
    {
        $req = $this->db->prepare('SELECT * FROM comment WHERE fk_post_id = :id');
        $req->execute(array('id' => $postId));
        $comments = $req->fetchAll();
        return $comments;
    }

    //delete a comment
    public function deleteComment($id)
    {
        $req = $this->db->prepare('DELETE FROM comment WHERE id = :id');
        $deleteComment = $req->execute(array(
            'id' => $id,
        ));
        return $deleteComment;
    }
}
