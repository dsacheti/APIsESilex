<?php


namespace SiApi\Data;


class BDConn
{
    private static $u = 'homestead';
    private static $p = 'secret';
    private static $bName = 'apis_silex';
    private static $host = 'localhost';
    private static $compl = [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
    private static $pdo_dados;

    public static function getBase()
    {
        if (isset(self::$pdo_dados)) {
            return self::$pdo_dados;
        } else {
            try{
                self::$pdo_dados = new \PDO('mysql:host='.self::$host.';dbname='.self::$bName, self::$u, self::$p,self::$compl);
                self::$pdo_dados->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
                return self::$pdo_dados;

            } catch (\PDOException $ex){
                echo $ex->getMessage();
                return $ex->getMessage();
            }
        }
    }

}