<?php
    $filepath = realpath(dirname(__FILE__));
    include ($filepath.'/../config/config.php');

    class Database{
        public $pdo;
        function __construct(){
            if(!isset($this->pdo)){
                try{
                    $link = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
                    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $link->exec("SET CHARACTER SET utf8");
                    $this->pdo = $link;
                }catch(PDOException $e){
                    die("Field to connect with Database".$e->getMessage());
                }
            }
        }
    }
?>