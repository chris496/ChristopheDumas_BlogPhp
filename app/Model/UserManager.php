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
    //display all users
    public function getAllUsers()
    {
        $req = $this->db->query('SELECT * FROM user');
        $allUsers = $req->fetchAll();
        return $allUsers;
    }
    //valid user
    public function validUser($id)
    {
        $req = $this->db->prepare('UPDATE user SET role = :role WHERE id = :id');
        $validUser = $req->execute(array(
            'role'=> '1',
            'id' => $id
        ));
        return $validUser;
    }

    public function userLogin($email, $password)
    {
        //login user
        $req = $this->db->prepare('SELECT * FROM user WHERE email = :email');
        $req->execute(array('email' => $email));
        $login = $req->fetch();
        return $login;
    }
}