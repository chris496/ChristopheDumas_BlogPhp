<?php

namespace App\blog\Model;

class UserManager extends Model
{
    //user registration
    public function userRegistration($lastname, $firstname, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $req = $this->db->prepare('INSERT INTO user(lastname, firstname, email, password) VALUES(?,?,?,?)');
        $newUser = $req->execute(array(
            $lastname,
            $firstname, 
            $email, 
            $hash,
        ));
        return $newUser;
    }
        /*
        {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $req = $this->db->prepare('INSERT INTO user(lastname, firstname, email, password) VALUES(:lastname, :firstname, :email, :password, :create_at)');
        $newUser = $req->execute(array(
            'lastname'=> $lastname,
            'firstname'=> $firstname,
            'email'=> $email,
            'password'=> $hash,
            ':create_at'=> date('Y-m-d H:i:s')
        ));
        return $newUser;
        }
        */

    public function userLogin($email, $password)
    {
        //login user
        $req = $this->db->prepare('SELECT * FROM user WHERE email = :email');
        $req->execute(array('email' => $email));
        $login = $req->fetch();
        return $login;
    }
}