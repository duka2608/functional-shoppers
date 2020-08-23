<?php
    if(isset($_POST['id'])){
        include "functions.php";
        include "../../../config/connection.php";
        header("Content-type: application/json");
        $id = $_POST['id'];
        $role = getRole($id);

        if($role->role == "administrator"){
            echo json_encode("Ne mozete izbrisati administratorski nalog.");
        }else{
            $flag = 1;
            $result = deleteUser($id);
            if($result){
                echo json_encode("Uspesno ste izbrisali korisnika.");
                //http_response_code(204);
            }else{
                http_response_code(500);
            }
        }
    }