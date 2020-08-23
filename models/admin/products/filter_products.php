<?php
    if(isset($_GET['send'])){
        header("Content-type: application/json");
        require_once "../../../config/connection.php";
        include "functions.php";
        if($_GET['send'] == "search"){

            $input = $_GET['input'];


            if($input == ""){            
                http_response_code(400);
            }else {
                $limit = $_GET['limit'];
                $products = searchProducts($input, $limit);
                $num = searchPaginationCount($input);


                echo json_encode([
                    "products" => $products,
                    "num" => $num
                ]);
            }
        }elseif($_GET['send'] == "filter-gender"){
            $gender_id = $_GET['gender_id'];

            $limit = $_GET['limit'];
            $products = filterGender($gender_id, $limit);
            $num = filterPaginationCount($gender_id);


            echo json_encode([
                "products" => $products,
                "num" => $num
            ]);
        }elseif($_GET['send'] == "filter-color"){
            $color_id = $_GET['color_id'];

            $limit = $_GET['limit'];
            $products = filterColor($color_id, $limit);
            $num = filterPaginationCountColor($color_id);

            echo json_encode([
                "products" => $products,
                "num" => $num
            ]);
        }
    }else {
        http_response_code(400);
    }