<?php
namespace App\blog\Controller;

use App\blog\Model\CommentManager;

class comment
{
    //create a new comment
    public function createComment($postId, $pseudo, $email, $description)
    {
        $commentManager = new CommentManager();
        $newComment = $commentManager->postComment($postId, $pseudo, $email, $description);
        header('Location: index.php?action=getOnePost&id=' . $postId);
        return $newComment;
    }

    //delete a comment
    public function deleteComment()
    {
        $postManager = new CommentManager();
        $postManager->deleteComment($_GET['id']);
        header('Location: index.php?action=pageAdministration');
    }
}