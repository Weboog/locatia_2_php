<?php


class Database {

    private static $dpo = null;

    protected function getInstance(){

        if(is_null(self::$dpo)){
            try{
                $dsn = 'mysql:dbname=locatia;host=localhost';
                self::$dpo = new PDO($dsn, 'root', '');
                return self::$dpo;
            }catch (PDOException $e){
                echo $e->getMessage();
            }
        }else{
            return self::$dpo;
        }

    }

}