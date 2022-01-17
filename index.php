<?php


require('./vendor/autoload.php');

require './app/Controller/Post.php';

$test = new Post();
$dis = $test->allPosts();
var_dump($dis);
