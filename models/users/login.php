<?php
    session_start();
    if(isset($_POST['send'])){
        header("Content-type: application/json");
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($username == "" || $password == ""){
            http_response_code(401);
        }else {

            include "../../config/connection.php";
            include "functions.php";
            try {
                $data = getLoginUser($username, $password);
                if($data->rowCount() == 1){
                    $_SESSION['user'] = $data->fetch();
                    $status = online($_SESSION['user']->user_id);
                    http_response_code(204);
                }else{
                    echo json_encode("pogresno");
                }
            } catch (PDOException $ex) {
                $ex->getMessage();
            }
        }
    }
