<?php
use App\blog\Model\UserManager;

class User
{
    //user registration
    public function userRegistration($firstname, $lastname, $email, $password)
    {
        $userManager = new UserManager();
        $userManager->userRegistration($firstname, $lastname, $email, $password);
        header('Location: index.php');
    }
}