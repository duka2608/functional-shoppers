<?php
    if(isset($_POST['id'])){
        header("Content-type: application/json");
        $pr_id = $_POST['id'];

        include "../../../config/connection.php";
        include "functions.php";

        $delete_product = deleteProduct($pr_id);
        if($delete_product){
            echo json_encode("Uspesno ste izbrisali korisnika.");
            http_response_code(204);
        }else{
            http_response_code(400);
        }
        var_dump($delete_product);
    }else {
        http_response_code(500);
    }