<?php

require('./vendor/autoload.php');

use app\blog\Model\PostManager;

$test = new PostManager;
$dis = $test->getPosts();
var_dump($dis);
