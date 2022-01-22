<?php
namespace app\blog\Model;

//use app\blog\Model\Model;

class PostManager extends Model{
    
    //display all posts
    public function getPosts(){
        $req =$this->db->query('SELECT id, title, chapo, update_date FROM post');
        $posts = $req->fetchAll();
        return $posts;
    }

    //display a selected post
    public function getPost($postId){
        $req = $this->db->prepare('SELECT lastname, firstname, title, chapo, description, post.update_date FROM user INNER JOIN post ON user.id = post.fk_user_id WHERE post.id = :id' );
        $req->execute(array('id'=> $postId));
        $post = $req->fetch();
        return $post;
    }
}


