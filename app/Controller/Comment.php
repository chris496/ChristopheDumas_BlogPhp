<?php

namespace App\blog\Controller;

use App\blog\Model\PostManager;
use App\blog\Model\CommentManager;

class comment extends Controller
{
    public function createComment($id, $pseudo, $email, $description)
    {
        $pseudo = htmlspecialchars($pseudo);
        $email = htmlspecialchars($email);
        $description = htmlspecialchars($description);

        $url_slug = $this->UrlSlug();

        if (!empty($id) && !empty($pseudo) && !empty($email) && !empty($description))
        {
            $pattern = '/^(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/';
            $patternEmail = '/.+\@.+\..+/';
            if(preg_match($pattern, $pseudo) && preg_match($patternEmail, $email))
            {
                $commentManager = new CommentManager();
                $commentManager->postComment($id, $pseudo, $email, $description);
                return header('Location: ../post/' .$id);
            }
            return $this->twig->display('errors.html.twig', [
            'error' => true,
            'url' => $url_slug
        ]);
        }
        return $this->twig->display('errors.html.twig', [
            'error' => true,
            'url' => $url_slug
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
