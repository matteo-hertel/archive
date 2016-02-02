<?php
namespace Db;

class Connection
{

    protected static $connection = null;

    private function __construct()
    {

    }

    public static function getConnection()
    {

        if (null === self::$connection) {
            self::$connection = self::createConnection();
        }

        return self::$connection;
    }

    protected static function createConnection(){
        return new \PDO('mysql:host=localhost;dbname=designpatternscourse', 'homestead', 'secret');
    }
}
