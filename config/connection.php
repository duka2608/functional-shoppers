<?php
    require_once "config.php";

    newActivity();

    try{
        $conn = new PDO("mysql:host=".SERVER.";dbname=".DBNAME.";charset=utf8", USER, PASSWORD);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }

    function newActivity(){
        $open = fopen(LOG_FILE, "a");
        $date = date("Y-m-d H:i:s");
        if($open){
            if(isset($_SESSION['user'])){
                fwrite($open, "{$date}\t{$_SERVER['PHP_SELF']}\t{$_SERVER['REMOTE_ADDR']}\t{$_SESSION['user']->first_name}\t{$_SESSION['user']->last_name}\n");
            }else {
                fwrite($open, "{$date}\t{$_SERVER['PHP_SELF']}\t{$_SERVER['REMOTE_ADDR']}\t{$_SERVER['HTTP_HOST']}\n");
            }
        }
        fclose($open);
    }

    function executeQuery($query){
        global $conn;
        return $conn->query($query)->fetchAll();
    }

    function executeQueryOneRow($query){
        global $conn;
        return $conn->query($query)->fetch();
    }