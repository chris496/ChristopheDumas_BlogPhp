<?php

namespace App\blog\Model;

class CommentManager extends Model
{
    //create a new comment
    public function postComment($postId, $pseudo, $email, $description, $added_date)
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
}