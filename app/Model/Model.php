<?php

namespace app\blog\Model;

require_once('./database.php');

class Model{
    protected $db;

    public function __construct(){
        $this->db = dbConnect();
    }
}