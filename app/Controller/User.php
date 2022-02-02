<?php
namespace App\blog\Controller;

use App\blog\Model\UserManager;

class User extends Controller
{
     //registration
     public function pageRegistration()
    {
        $this->twig->display('registration.html.twig');
    }
    //user registration
    public function userRegistration($lastname, $firstname, $email, $password)
    {
        $userManager = new UserManager();
        $userManager->userRegistration($lastname, $firstname, $email, $password);
        header('Location: index.php');
    }
}