<?php
    if(isset($_POST['id'])){
        include "functions.php";
        include "../../../config/connection.php";
        header("Content-type: application/json");
        $id = $_POST['id'];

        $user = updateUser($id);

        if($user){
            echo json_encode($user);
        }else {
            http_response_code(500);
        }
    }else {
        http_response_code(400); 
    }