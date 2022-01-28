<?php
//use PDO;
use Symfony\Component\Dotenv\Dotenv;

function dbConnect()
{
    $dotenv = new Dotenv();
    $dotenv->load(__DIR__.'/.env');
    $dbhost = $_ENV['DB_HOST'];
    $dbname = $_ENV['DB_NAME'];
    $username = $_ENV['DB_USERNAME'];
    $password = $_ENV['DB_PASSWORD'];

    try
    {
        $pdo = new PDO(
            "mysql:host=$dbhost;dbname=$dbname;charset=utf8", 
            "$username", 
            "$password"
        );
        return $pdo;
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
}