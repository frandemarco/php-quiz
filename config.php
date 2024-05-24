<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
const DB_SERVER = "localhost";
const DB_USERNAME = 'db_user';
const DB_PASSWORD = 'Password123';
const DB_NAME = 'Quiz';

//define('DB_SERVER', 'localhost');
//define('DB_USERNAME', 'db_user');
//define('DB_PASSWORD', 'Password123');
//define('DB_NAME', 'login');

/* Attempt to connect to MySQL database */
function getDBConnection()
{
    try{
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e){
        die("ERROR: Could not connect. " . $e->getMessage());
    }
}

?>
