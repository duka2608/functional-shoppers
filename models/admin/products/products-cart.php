<?php
    if(isset($_POST['ids'])){
        header("Content-Type: application/json");
        include "functions.php";
        include "../../../config/connection.php";

        $p_ids = $_POST['ids'];
        $products = getCart($p_ids);
        if(count($products) > 0){
            echo json_encode($products);
            http_response_code(200);
        }else{
            http_response_code(400);
        }
    }