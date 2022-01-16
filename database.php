<?php

function dbConnect(){
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=blogphp;charset=utf8', 'root', 'Sql@42ocBdd496');
        return $pdo;
    }
    catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }
}

$db = dbConnect();
$res = $db->query('SELECT * FROM post');
$result = $res->fetchAll();