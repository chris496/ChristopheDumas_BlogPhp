<?php

namespace App\blog\Model;

class UserManager extends Model
{
    //user registration
    public function userRegistration($firstname, $lastname, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $req = $this->db->prepare('INSERT INTO user(firstname, lastname, email, password) VALUES(?,?,?,?,?)');
        $newUser = $req->execute(array(
            $firstname, 
            $lastname, 
            $email, 
            $hash,
        ));
        return $newUser;
    }
}