<?php
namespace App\blog\Controller;

use App\blog\Model\CommentManager;

class comment
{
    //create a new comment
    public function createComment($postId, $pseudo, $email, $description)
    {
        $postId = htmlspecialchars($postId);
        $pseudo = htmlspecialchars($pseudo);
        $email = htmlspecialchars($email);
        $description = htmlspecialchars($description);

        if (!empty($postId) && !empty($pseudo) && !empty($email) && !empty($description))
        {
            $pattern = '/^(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/';
            $patternEmail = '/.+\@.+\..+/';
            if(preg_match($pattern, $pseudo) && preg_match($patternEmail, $email))
            {
                $commentManager = new CommentManager();
                $newComment = $commentManager->postComment($postId, $pseudo, $email, $description);
                header('Location: index.php?action=getOnePost&id=' . $postId);
                return $newComment;
            }
            else
            {
                $this->twig->display('index.php?action=getOnePost&id=' . $postId, [
                    'error' => true
                ]);
            
            }
        }
        else
        {
            $this->twig->display('index.php?action=getOnePost&id=' . $postId, [
                'vide' => true
            ]);
        }
    }

    //validate comment
    public function validComment()
    {
        $superglobals = new SuperGlobals();
        $get = $superglobals->getGET();

        $validComment = new CommentManager();
        $valid = $validComment->validComment($get['id']);
        header('Location: index.php?action=pageAdministration');
        return $valid; 
    }

    //delete a comment
    public function deleteComment()
    {
        $superglobals = new SuperGlobals();
        $get = $superglobals->getGET();
        
        $postManager = new CommentManager();
        $postManager->deleteComment($get['id']);
        header('Location: index.php?action=pageAdministration');
    }
}