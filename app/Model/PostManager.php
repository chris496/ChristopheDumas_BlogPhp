<?php
namespace app\blog\Model;

//use app\blog\Model\Model;

class PostManager extends Model{
    
    //display all posts
    public function getPosts(){
        $req =$this->db->query('SELECT title, chapo, update_date FROM post');
        $posts = $req->fetchAll();
        return $posts;
    }
}


