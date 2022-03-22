<?php

namespace App\blog\Controller;

use App\blog\Model\PostManager;
use App\blog\Model\CommentManager;

class comment
{
    public function createComment($id, $pseudo, $email, $description)
    {
        $pseudo = htmlspecialchars($pseudo);
        $email = htmlspecialchars($email);
        $description = htmlspecialchars($description);

        if (!empty($id) && !empty($pseudo) && !empty($email) && !empty($description))
        {
            $pattern = '/^(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/';
            $patternEmail = '/.+\@.+\..+/';
            if(preg_match($pattern, $pseudo) && preg_match($patternEmail, $email))
            {
                $commentManager = new CommentManager();
                $commentManager->postComment($id, $pseudo, $email, $description);
                //return header('Location: ../' . $id);$user = $this->isAdmin();
                //$postManager = new PostManager();
                //$post = $postManager->getPost($id);
                //$comments = $commentManager->getComments($id);

                return header('Location: ../post/' .$id);
            }
            return header('Location: ../post/' .$id);
        }
        return $this->twig->display('onePost.html.twig', [
            'vide' => true
        ]);
    }
    
    //validate comment
    public function validComment($id)
    {
        $validComment = new CommentManager();
        $validComment->validComment($id);
        return header('Location: ../pageAdministration');
    }

    //delete a comment
    public function deleteComment($id)
    {
        $postManager = new CommentManager();
        $postManager->deleteComment($id);
        return header('Location: ../pageAdministration');
    }
}
