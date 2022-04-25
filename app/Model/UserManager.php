<?php

namespace App\blog\Model;

use PDO;
use App\blog\Entity\UserEntity;

class UserManager extends Model
{
    private $db;
    //user registration
    public function userRegistration($user)
    {
        $lastname = $user->getLastname();
        $firstname = $user->getFirstname();
        $email = $user->getEmail();
        $password = $user->getPassword();

        $this->db = Model::getPdo();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $req = $this->db->prepare('INSERT INTO user(lastname, firstname, email, password) VALUES(?,?,?,?)');
        return $req->execute(array(
            $lastname,
            $firstname,
            $email,
            $hash,
        ));
    }
    //display all users
    public function getAllUsers()
    {
        $this->db = Model::getPdo();
        $req = $this->db->query('SELECT * FROM user');
        return $req->fetchAll(PDO::FETCH_CLASS, UserEntity::class);
    }
    //valid user
    public function validUser($id)
    {
        $this->db = Model::getPdo();
        $req = $this->db->prepare('UPDATE user SET role = :role WHERE id = :id');
        return $req->execute(array(
            'role' => '1',
            'id' => $id
        ));
    }

    public function userLogin($email)
    {
        //login user
        $this->db = Model::getPdo();
        $req = $this->db->prepare('SELECT * FROM user WHERE email = :email');
        $req->execute(array('email' => $email));
        return $req->fetchObject(UserEntity::class);
    }
}
