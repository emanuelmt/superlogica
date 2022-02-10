<?php

class Connection
{

    private static $Host = HOST;
    private static $Driver = DRIVER;
    private static $User = USER;
    private static $Pass = PASS;
    private static $Dbsa = DBSA;
    private static $Connection = null;

    private static function Connect()
    {
        try {
            if (self::$Connection == null) {
                $dsn = self::$Driver . ':host=' . self::$Host . ';dbname=' . self::$Dbsa . ';charset=utf8';
                $options = self::$Driver == 'mysql' ? [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'] : [];
                self::$Connection = new \PDO($dsn, self::$User, self::$Pass, $options);
            }
        } catch (PDOException $e) {
            echo "Não foi possivel realizar a conexão com o banco de dados!";
            die;
        }
        self::$Connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return self::$Connection;
    }

    public static function GetConnection(): PDO
    {
        return self::Connect();
    }
}
