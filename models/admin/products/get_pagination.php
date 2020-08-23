<?php

header("Content-Type: application/json");

if(isset($_GET['limit'])){
    require_once "../../../config/connection.php";
    include "functions.php";

    $limit = $_GET['limit'];
    $products = getProducts($limit);
    $num = paginationCount();

    echo json_encode([
        "products" => $products,
        "num" => $num
    ]);
} else {
    echo json_encode(["message"=> "Limit not passed."]);
    http_response_code(400);
}