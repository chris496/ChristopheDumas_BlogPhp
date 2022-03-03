<?php

namespace App\blog\Model;

require_once('./database.php');

class Model
{
    protected $db;

    public function __construct()
    {
        return $this->db = dbConnect();
    }
}
