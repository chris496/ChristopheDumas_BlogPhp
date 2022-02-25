<?php
//use PDO;
use Symfony\Component\Dotenv\Dotenv;
use App\blog\Controller\SuperGlobals;

function dbConnect()
{
    $dotenv = new Dotenv();
    $dotenv->load(__DIR__ . '/.env');

    $superglobals = new SuperGlobals();
    $env = $superglobals->getENV();

    $dbhost = $env['DB_HOST'];
    $dbname = $env['DB_NAME'];
    $username = $env['DB_USERNAME'];
    $password = $env['DB_PASSWORD'];

    try {
        $pdo = new PDO(
            "mysql:host=$dbhost;dbname=$dbname;charset=utf8",
            "$username",
            "$password"
        );
        return $pdo;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
