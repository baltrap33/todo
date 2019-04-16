<?php
include $_SERVER['DOCUMENT_ROOT']."/config/db.php";
class DbPdo {
    public static function pdoConnexion(){
        $mysql = "mysql:host=".HOST.";port=".PORT.";dbname=".DBNAME.";";
        try{
            $connexion = new PDO($mysql, USER, PWD);
            $connexion->exec("SET NAMES utf8");
        }catch(Exception $exception){
            echo 'N° error :'.$exception->getCode().' - ';
            echo 'Error :'.$exception->getMessage();
            die();
        }
        return $connexion;
    }
}
