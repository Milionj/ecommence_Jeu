<?php
class Database
{
    private static $dbHost = 'localhost';
    private static $dbName = 'jeuxvideo';
    private static $dbUser = 'root';
    private static $dbPass = '';

    private static $connection = null;

    public static function connect()
    {
        if(null === self::$connection){
            try{
        self::$connection = new PDO('mysql:host=' . self::$dbHost . ';dbname=' . self::$dbName . ';charset=utf8', self::$dbUser, self::$dbPass);
            } 
            catch (PDOException $e){
                die($e->getMessage());
            }
            return self::$connection;
        }
        
    }

    public static function disconnect()
    {
        self::$connection = null;
    }
}

//$db = new Database(); // Instance
//$db = Database::connect(); // Connection via méthodes static 