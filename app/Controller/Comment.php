<?php

namespace App\blog\Controller;

use App\blog\Model\CommentManager;

class comment
{
    public function createComment($id, $pseudo, $email, $description)
    {
        $postId = htmlspecialchars($id);
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
                return header('Location: ../' . $id);
            }
            return header('Location: getOnePost/' . $id);
        }
        return $this->twig->display('getOnePost/' . $id, [
            'vide' => true
        ]);
    }
    
    //validate comment
    public function validComment($id)
    {
        $superglobals = new SuperGlobals();
        $get = $superglobals->getGET();

        $validComment = new CommentManager();
        $validComment->validComment($id);
        return header('Location: ../pageAdministration');
    }

    //delete a comment
    public function deleteComment($id)
    {
        $superglobals = new SuperGlobals();
        $get = $superglobals->getGET();

        $postManager = new CommentManager();
        $postManager->deleteComment($id);
        return header('Location: ../pageAdministration');
    }
}
