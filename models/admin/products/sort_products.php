<?php
    if(isset($_GET['sort'])){
        header("Content-type: application/json");
        require_once "../../../config/connection.php";
        include "functions.php";

        $sort = $_GET['sort'];
        $limit = $_GET['limit'];

        $query = sortQuery();

        switch($sort){
            case 1:
                $query .= " ORDER BY p.title ASC LIMIT $limit, 6";
                break;
            case 2:
                $query .= " ORDER BY p.title DESC LIMIT $limit, 6";
                break;
            case 3:
                $query .= " ORDER BY p.price ASC LIMIT $limit, 6";
                break;
            case 4:
                $query .= " ORDER BY p.price DESC LIMIT $limit, 6";
                break;
        }

        $products = executeQuery($query);
        $num = paginationCount();
        echo json_encode([
            "products" => $products,
            "num" => $num
        ]);

    }