<?php

namespace App\blog\Model;

use PDO;
use App\blog\SuperGlobals;
use Symfony\Component\Dotenv\Dotenv;

class Model
{
    private static $instance = null;

    /**
     * @return PDO
     */
    public static function getPdo(): PDO
    {
        $dotenv = new Dotenv();
    
        $dotenv->load(dirname(__FILE__,3) . '/.env');
    
        $superglobals = new SuperGlobals();
        $env = $superglobals->getENV();

        $dbhost = $env['DB_HOST'];
        $dbname = $env['DB_NAME'];
        $username = $env['DB_USERNAME'];
        $password = $env['DB_PASSWORD'];
    
        if (self::$instance === null) {
            self::$instance = new PDO(
                "mysql:host=$dbhost;dbname=$dbname;charset=utf8",
                "$username",
                "$password"
            );
        }
        
        return self::$instance;
    }
}